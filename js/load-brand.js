$(document).ready(function() {
  //get brands
  $.get({
    type: 'get',
    url: './data-processing/retrieve-brand.php',
    dataType: 'json',
    encode: true
  }).done(function(data) {
    console.log(data);

    //retrieve brand name and the reference
    //then we display this data via a tags
    for (i = 0; i < data.length; i++) {
      var brandName = data[i]["brandName"].toUpperCase();
      var dbRef = data[i]["dbRef"];
      $(".search-brands").append(buildBrandLink(brandName, dbRef));
    }
  }).fail(function(data) {
    console.log(data);
  });

  // $('.brand-link').click(function(event) {
  //   console.log("clicked");
  //   console.log(event.target);
  // });
  $('.btn-set-favorite').click(function() {
    var sneakerInfo = {
      sneakerId: $(".snkr-id").text(),
      sneakerName: $(".snkr-name").text()
    }

    $.ajax({
      type: 'post',
      url: './data-processing/favorite.php',
      data: sneakerInfo
    }).done(function(data, status) {});
  });

  //since we are updating the page dynamically
  //we have to use this function to attach a click listener to the brand list
  $(document).on("click", "a.brand-link", function(event) {
    var prepareBrandSearch = {
      dbRef: $(this).data("dbRef").dbRef
    }

    //send the dbRef to search-by-brand php
    $.ajax({
      type: 'post',
      url: './data-processing/search-by-brand.php',
      data: prepareBrandSearch
    }).done(function(data, status) {
      console.log(data);
    });
  })

  function buildBrandLink(brandName, dbRef) {
    //we set the class name of the link "brand-link"
    var brandLink = $("<a/>", {
      class: "brand-link",
    });

    brandLink.text(brandName);
    brandLink.data("dbRef", {dbRef: dbRef}); //each link will be unique using a hidden data attribute
    return brandLink;
  }
});
