"use strict";
var page = require('webpage').create();

page.onConsoleMessage = function(msg) {
    console.log(msg);
};

page.open("http://www.accesscodeschool.fr/blog/", function(status) {
    if (status === "success") {
        page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {
            page.evaluate(function() {
                console.log($("H2").first().text());
            });
            phantom.exit(0);
        });
    } else {
      phantom.exit(1);
    }
});