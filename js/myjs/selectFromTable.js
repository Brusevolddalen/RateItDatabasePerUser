$(document).on("click", "#table>tbody>tr", function() {
  //console.log(this.text());
  //console.log($(this).text());
  let selected = $(this).text().replace(/ /g,'');
  console.log(selected);
  localStorage.clear();
  localStorage.setItem("selected", selected);
  window.location.href = 'items.html?category='+selected;

});
