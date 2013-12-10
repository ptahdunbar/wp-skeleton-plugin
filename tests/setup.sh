#!/bin/sh

# WordPress test setup script for Travis CI
#
# Author: Benjamin J. Balter ( ben@balter.com | ben.balter.com )
# License: GPL2+

# flag to use a custom content dir.
if [[ ! $WP_CONTENT ]]; then
    export WP_CONTENT=wp-content
fi

# flag to set WordPress version to test under
if [[ ! $WP_VERSION ]]; then
    export WP_VERSION=3.7-branch
else
    echo $WP_VERSION
fi

# flag to set the db user
if [ -z "$DB_USER" ]; then
    export DB_USER=root
fi

# flag to set the db host
if [[ -z "$DB_HOST" ]]; then
    export DB_HOST=localhost
fi

# flag to set the db pass
if [[ -z "$DB_PASS" ]]; then
    export $DB_PASS=""
    export DB_PASSWORDLESS=""
else
    export DB_PASSWORDLESS="-p$DB_PASS"
fi

# flag to set the WordPress dir to test under
if [[ ! -e $WP_CORE_DIR ]]; then
    export WP_CORE_DIR=/tmp/wordpress/$WP_VERSION

    # Create MySQL database
    echo "Creating MySQL database: wordpress_test"
    mysql -e 'DROP DATABASE IF EXISTS wordpress_test;' -u$DB_USER $DB_PASSWORDLESS
    mysql -e 'CREATE DATABASE wordpress_test;' -u$DB_USER $DB_PASSWORDLESS

    if [[ ! -e $WP_CORE_DIR ]]; then
        echo "Downloading WordPress version: $WP_VERSION and extracting it into $WP_CORE_DIR"
        wget -nv -O /tmp/wordpress.tar.gz https://github.com/WordPress/WordPress/tarball/$WP_VERSION
        mkdir -p $WP_CORE_DIR
        tar --strip-components=1 -zxmf /tmp/wordpress.tar.gz -C $WP_CORE_DIR
    else
        echo "Skipping WordPress download. Using existing install in $WP_CORE_DIR"
    fi
else
    echo "Skipping WordPress download. Using existing install in $WP_CORE_DIR"
fi

# flag to set the WordPress test framework dir to run the tests under
if [[ ! -e $WP_TESTS_DIR ]]; then
    export WP_TESTS_DIR=/tmp/wordpress/tests

    if [[ ! -e $WP_TESTS_DIR ]]; then
        echo "Downloading WordPress testing framework into $WP_TESTS_DIR"
        svn co --quiet --ignore-externals http://develop.svn.wordpress.org/trunk/ $WP_TESTS_DIR
    else
        echo "Skipping WordPress tests framework download. Using existing install tests directory in $WP_TESTS_DIR"
    fi

else
    echo "Skipping WordPress Tests download. Using existing install tests directory in $WP_TESTS_DIR"
fi

echo "Updating wp-tests-config.php with database settings"
cp $WP_TESTS_DIR/wp-tests-config-sample.php $WP_TESTS_DIR/wp-tests-config.php

sed -e 's/youremptytestdbnamehere/wordpress_test/' $WP_TESTS_DIR/wp-tests-config.php > $WP_TESTS_DIR/wp-tests-config.tmp.php
mv $WP_TESTS_DIR/wp-tests-config.tmp.php $WP_TESTS_DIR/wp-tests-config.php

sed -e "s/yourusernamehere/"$DB_USER"/g" $WP_TESTS_DIR/wp-tests-config.php > $WP_TESTS_DIR/wp-tests-config.tmp.php
mv $WP_TESTS_DIR/wp-tests-config.tmp.php $WP_TESTS_DIR/wp-tests-config.php

sed -e "s/yourpasswordhere/"$DB_PASS"/g" $WP_TESTS_DIR/wp-tests-config.php > $WP_TESTS_DIR/wp-tests-config.tmp.php
mv $WP_TESTS_DIR/wp-tests-config.tmp.php $WP_TESTS_DIR/wp-tests-config.php

sed -e "s:define( 'ABSPATH', dirname( __FILE__ ) . '/src/' );:define( 'ABSPATH', getenv( 'WP_CORE_DIR' ) . '/' );:g" $WP_TESTS_DIR/wp-tests-config.php > $WP_TESTS_DIR/wp-tests-config.tmp.php
mv $WP_TESTS_DIR/wp-tests-config.tmp.php $WP_TESTS_DIR/wp-tests-config.php

sed "s:// define( 'WP_TESTS_MULTISITE', true );:define( 'WP_TESTS_MULTISITE', (bool) getenv( 'WP_MULTISITE' ) );:g" $WP_TESTS_DIR/wp-tests-config.php > $WP_TESTS_DIR/wp-tests-config.tmp.php
mv $WP_TESTS_DIR/wp-tests-config.tmp.php $WP_TESTS_DIR/wp-tests-config.php

sed -e "s,localhost,"$DB_HOST"," $WP_TESTS_DIR/wp-tests-config.php > $WP_TESTS_DIR/wp-tests-config.tmp.php
mv $WP_TESTS_DIR/wp-tests-config.tmp.php $WP_TESTS_DIR/wp-tests-config.php

# Put various components in proper folders
plugin_slug=$(basename $(pwd))
plugin_dir=$WP_CORE_DIR/$WP_CONTENT/plugins/$plugin_slug

if [[ ! -e $plugin_dir ]]; then
    cd ..
    cp -r $plugin_slug $plugin_dir
fi

cd $plugin_dir

exit 0