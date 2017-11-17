 $(document).ready(function() {

   /*
   Handlebars.registerHelper('ifEquals', function(arg1, arg2, options) {
     return (arg1 == arg2) ? options.fn(this) : options.inverse(this);
   });
   */

   Handlebars.registerHelper('if_eq', function(a, b, opts) {
     if (a == b) {
       return opts.fn(this);
     } else {
       return opts.inverse(this);
     }
   });
   Handlebars.registerHelper('grouped_each', function(every, context, options) {
     var out = "",
       subcontext = [],
       i;
     if (context && context.length > 0) {
       for (i = 0; i < context.length; i++) {
         if (i > 0 && i % every === 0) {
           out += options.fn(subcontext);
           subcontext = [];
         }
         subcontext.push(context[i]);
       }
       out += options.fn(subcontext);
     }
     return out;
   });

   let selected = localStorage.getItem("selected")
   $('title').html(selected + "| myExperience");

   let output = {
     tableContent: [],
     headers: []
   };
   //let headers=[];
   let itemSource = $("#itemTemplate").html();
   let itemTemplate = Handlebars.compile(itemSource);

   let addItemSource = $("#addItemTemplate").html();
   let addItemTemplate = Handlebars.compile(addItemSource);



   $.getJSON("php/loadTableHeaders.php?category=" + selected, function(data) {

     for (let i = 0; i < data.length; i++) {
       output.headers.push(
         data[i]
       );
     }
          output.headers.push(
            "edit","delete"
          );

   });


   $.getJSON("php/loadTableContent.php?category=" + selected, function(data) {
     //Deletes first item in data (the ID)
     for (let i = 0; i < data.length; i++) {
       //delete data[i].id;
       output.tableContent.push({
         items: data[i]
       });
     }

     console.log(output)
     $("#tableContainer").append(itemTemplate(output));

     //deletes unwated columns when user wants to add item
     output.headers.splice($.inArray("id", output.headers), 1);
     output.headers.splice($.inArray("edited", output.headers), 1);
     output.headers.splice($.inArray("edit", output.headers), 1);
     output.headers.splice($.inArray("delete", output.headers), 1);

     $("#addItemContainer").append(addItemTemplate(output));
   });

   //$("#tableContainer").append(template(output));

 });
