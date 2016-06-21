var webPage = require('webpage');
var page = webPage.create();

page.open('http://www.ikea.com/fr/fr/catalog/products/S29097737/', function(status) {

  var title = page.evaluate(function() {
    return document.meta;
  });

  console.log(title);
  phantom.exit();

});