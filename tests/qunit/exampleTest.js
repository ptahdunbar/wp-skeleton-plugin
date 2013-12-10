test( "hello test", function() {
	ok( 1 == "1", "Passed!" );
});

test("should inspect jQuery.getJSON's usage of jQuery.ajax", function () {

	this.spy(jQuery, 'ajax');
	jQuery.getJSON("/some/resource");

	ok(jQuery.ajax.calledOnce);
	equal(jQuery.ajax.getCall(0).args[0].url, "/some/resource");
	equal(jQuery.ajax.getCall(0).args[0].dataType, "json");
});