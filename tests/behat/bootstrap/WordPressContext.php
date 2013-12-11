<?php

// https://github.com/maartenJacobs/WordPress-Behat-Context

namespace WordPress\Mink\Context;
use Behat\MinkExtension\Context\MinkContext as BehatContext;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

class WordPress_Context extends BehatContext {

    protected $base_url;
    protected $role_map;
    protected $session;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param   array   $parameters     context parameters (set them up through behat.yml)
     */
    public function __construct(array $params) {
        $this->base_url = $params['base_url'];
        $this->role_map = $params['role_map'];
    }

    /**
     * Given a list of usernames (user_login field), checks for every username
     * if they exist. Returns a list of the users that do not exist.
     *
     * @param array $users
     * @return array
     * @author Maarten Jacobs
     **/
    protected function check_users_exist(array $users) {
        $session = $this->getSession();

        // Check if the users exist, saving the inexistent users
        $inexistent_users = array();
        $this->visit( 'wp-admin/users.php' );
        $current_page = $session->getPage();
        foreach ($users as $username) {
            if (!$current_page->hasContent($username)) {
                $inexistent_users[] = $username;
            }
        }

        return $inexistent_users;
    }

    /**
     * Creates a user for every username given (user_login field).
     * The inner values can also maps of the following type:
     *  array(
     *    'username' =>
     *    'password' => (default: pass)
     *    'email' => (default: username@test.dev)
     *    'role' => (default: checks rolemap, or 'subscriber')
     *  )
     *
     * @param array $users
     * @author Maarten Jacobs
     **/
    protected function create_users(array $users) {
        $session = $this->getSession();

        foreach ($users as $username) {
            if (is_array($username)) {
                $name = $username['username'];
                $password = array_key_exists('password', $username) ? $username['password'] : 'pass';
                $email = array_key_exists('email', $username) ? $username['email'] : str_replace(' ', '_', $name) . '@test.dev';
            } else {
                $name = $username;
                $password = 'pass';
                $email = str_replace(' ', '_', $name) . '@test.dev';
            }

            $this->visit( 'wp-admin/user-new.php' );
            $current_page = $session->getPage();

            // Fill in the form
            $current_page->findField('user_login')->setValue($name);
            $current_page->findField('email')->setValue($email);
            $current_page->findField('pass1')->setValue($password);
            $current_page->findField('pass2')->setValue($password);

            // Set role
            $role = ucfirst( strtolower( $this->role_map[$name] ) );
            $current_page->findField('role')->selectOption($role);

            // Submit form
            $current_page->findButton('Add New User')->click();
        }
    }

    /**
     * Fills in the form of a generic post.
     * Given the status, will either publish or save as draft.
     *
     * @param string $post_type
     * @param string $post_title
     * @param string $status Either 'draft' or anything else for 'publish'
     * @author Maarten Jacobs
     **/
    protected function fill_in_post($post_type, $post_title, $status = 'publish', $content = '<p>Testing all the things. All the time.</p>') {
        // The post type, if not post, will be appended.
        // Rather than a separate page per type, this is how WP works with forms for separate post types.
        $uri_suffix = $post_type !== 'post' ? '?post_type=' . $post_type : '';
        $this->visit( 'wp-admin/post-new.php' . $uri_suffix );
        $session = $this->session = $this->getSession();
        $current_page = $session->getPage();

        // Fill in the title
        $current_page->findField( 'post_title' )->setValue( $post_title );
        // Fill in some nonsencical data for the body
        // clickLink and setValue seem to be failing for TinyMCE (same for Cucumber unfortunately)
        $session->executeScript( 'jQuery( "#content-html" ).click()' );
        $session->executeScript( 'jQuery( "#content" ).val( ' . $content . ' )' );

        // Click the appropriate button depending on the given status
        $state_button = 'Save Draft';
        switch ($status) {
            case 'draft':
                // We're good.
                break;

            case 'publish':
            default:
                // Save as draft first
                $current_page->findButton($state_button)->click();
                $state_button = 'Publish';
                break;
        }
        $current_page->findButton($state_button)->click();

        // Check if the post exists now
        $this->visit( 'wp-admin/edit.php' . $uri_suffix );
        assertTrue( $this->getSession()->getPage()->hasContent( $post_title ) );
    }

    /**
     * Makes sure the current user is logged out, and then logs in with
     * the given username and password.
     *
     * @param string $username
     * @param string $password
     * @author Maarten Jacobs
     **/
    protected function login($username, $password = 'pass') {
        $session = $this->session = $this->getSession();
        $current_page = $session->getPage();

        // Check if logged in as that user
        $this->visit( 'wp-admin' );
        if ($current_page->hasContent( "Howdy, {$username}" )) {
            // We're already logged in as this user.
            // Double-check
            assertTrue( $session->getPage()->hasContent('Dashboard') );
            return true;
        }

        // Logout
        $this->visit( 'wp-login.php?action=logout' );
        if ($session->getPage()->hasLink('log out')) {
            $current_page->find('css', 'a')->click();
            $current_page = $session->getPage();
        }

        // And login
        $current_page->fillField('user_login', $username);
        $current_page->fillField('user_pass', $password);
        $current_page->findButton('wp-submit')->click();

        // Assert that we are on the dashboard
        assertTrue( $session->getPage()->hasContent('Dashboard') );
    }

    /**
     * Given the current page is post list page, we enter the title in the searchbox
     * and search for that post.
     *
     * @param string $post_title The title of the post as it would appear in the WP backend
     * @param boolean $do_assert If set to anything but false, will assert for the existence of the post title after the search
     * @return void
     * @author Maarten Jacobs
     **/
    protected function searchForPost( $post_title, $do_assert = FALSE ) {

        $current_page = $this->getSession()->getPage();

        // Search for the post
        $search_field = $current_page->findField( 'post-search-input' ); // Searching on #id
        // When there is no content, then the searchbox is not shown
        // So we skip search in that case
        if ($search_field) {
            $search_field->setValue( $post_title );

            $current_page->findField( 'Search Posts' ) // Searching on value
                ->click();
        }

        // We don't stop tests even if the searchbox does not exist.
        // That would prevent the dev from knowing what the hell's going on.
        // Can I assert all the things?
        if ( $do_assert ) {
            assertTrue( $current_page->hasContent($post_title) );
        }

    }

    /**
     * @Given /^I trash the "([^"]*)" titled "([^"]*)"$/
     */
    public function iTrashThePostTitled( $post_type, $post_title ) {

        $session = $this->session = $this->getSession();

        // Visit the posts page
        $uri_suffix = $post_type !== 'post' ? '?post_type=' . $post_type : '';
        $postlist_uri = 'wp-admin/edit.php' . $uri_suffix;
        $this->visit( $postlist_uri );
        $current_page = $session->getPage();

        // Check if the post with that title is on the current page
        if (!$current_page->hasContent( $post_title )) {
            // If not, search for the post
            $this->searchForPost( $post_title );
        }
        assertTrue( $current_page->hasContent($post_title) );

        // Select the post in the checkbox column
        // This is tricky: the checkbox has a non-unique name (of course, that's the way to do it)
        // So we need to check the box in a different way
        // The easiest: jQuery
        $session->executeScript( "jQuery( \"tr:contains('$post_title') :checkbox\" ).click()" );

        // Trash it
        //  - Select the 'Move to Trash' option
        $current_page->selectFieldOption( 'action', 'Move to Trash' );
        //  - Click to Apply
        $current_page->findButton( 'doaction' )->click();

        // Check if the post is no longer visible on the posts page
        $this->visit( $postlist_uri );
        assertFalse( $current_page->hasContent( $post_title ) );
        // Make a search, because it could be on another page
        $this->searchForPost( $post_title );
        assertFalse( $current_page->hasContent($post_title) );

    }

}