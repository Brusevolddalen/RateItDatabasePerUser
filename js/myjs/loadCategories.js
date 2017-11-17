$(document).ready(function() {

  //Gets data from database
  Handlebars.registerHelper('with', function(context, options) {
    return options.fn(context);
  });

  $.getJSON("php/loadCategories.php", function(data) {

    let source = $("#categoryTemplate").html();
    let template = Handlebars.compile(source);
    var output = {
      categories: []
    };

    let propertyName = Object.keys(data[0]).toString();

    //Rename the query from Tables_in_USERNAME to categoryname
    data = data.map(function(obj) {
      obj['categoryname'] = obj[propertyName];
      delete obj[propertyName];
      return obj;
    });

    //Adds the categorynames to output array and capitalizes the first letter in the array
    for (let i = 0; i < data.length; i++) {
      output.categories.push({
        categoryName: data[i].categoryname.charAt(0).toUpperCase() + data[i].categoryname.substr(1)
      });
    }
    //Fills Array with the result from PHP
    $("#tableContainer").append(template(output));
  });
});
