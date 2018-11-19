$(document).ready(function() {
  $('.register').submit(function(event) {

    event.preventDefault();
    var registerFormData = {
      //takes the values of the form
      'username-register' : $('input[name=username-register]').val(),
      'email-register' : $('input[name=email-register]').val(),
      'password-register' : $('input[name=password-register]').val(),
      'password-confirm-register' : $('input[name=password-confirm-register]').val()
    };

    $.ajax({
      type : 'POST',
      url : './data-processing/register.php',
      data : registerFormData,
      dataType : 'json',
      encode : true
    }).done(function(data) {
      console.log(data);
      //error validation

      if (!data.success) {
        if (data.errors.username) {
          $('input[name=username-register]').after('<span class="error">' + data.errors.username + '</span>');
        }

        if (data.errors.email) {
          $('input[name=email-register]').after('<span class="error">' + data.errors.email + '</span>')
        }

        if (data.errors.password) {
          $('input[name=password-register]').after('<span class="error">' + data.errors.password + '</span>');
        }

        if (data.errors.confirmPassword) {
          $('input[name=password-confirm-register]').after('<span class="error">' + data.errors.confirmPassword + '</span>');
        }

        $('form').submit(function(event) {
          //removes the error messages when submitting
          $('.error').remove();
        });

      } else {
        alert("Success!");
        window.location.replace('index.php');
      }
    }).fail(function(data){
      console.log('fail');
      console.log(data);
    });
  });

  $('.log-in').submit(function(event) {

    event.preventDefault();
    var formData = {
      //takes the values of the form
      'username-sign-in' : $('input[name=username-sign-in]').val(),
      'password-sign-in' : $('input[name=password-sign-in]').val()
    };

    $.ajax({
      type : 'POST',
      url : './data-processing/sign-in.php',
      data : formData,
      dataType : 'json',
      encode : true
    }).done(function(data) {
      console.log(data);
      //error validation

      if (!data.success) {
        if (data.errors.username) {
          $('input[name=username-sign-in]').after('<span class="error">' + data.errors.username + '</div');
        }

        if (data.errors.password) {
          $('input[name=password-sign-in]').after('<span class="error">' + data.errors.password + '</div');
        }

        $('form').submit(function(event) {
          //removes the error messages
          $('.error').remove();
        });

      } else {
        alert("Success!");
        // window.location.replace('index.php');
        $.ajax({
          type: 'GET',
          url: './data-processing/redirect-page.php',
          dataType: 'json',
          encode: true
        }).done(function(data, status) {
          window.location.replace(data);
        });
      }
    }).fail(function(data){
      console.log('fail');
      console.log(data);
    });

    //prevents click anchors to run to a new URL, which is their default behaviours
  });

  //ajax function retrieve data coming from search-processing.php
  //in the event the user searches something
  $.get({
    type: 'get',
    url: './data-processing/search-processing.php',
    dataType: 'json',
    encode: true
  }).done(function(data) {
    console.log(data);
    //empty previous search queries
    $(".search-results").empty();

    //if search query returns nothing, we return the message below
    //we need to specify that the message below is a DOM with error-msg class
    if (data.dataEmpty) {
      var dataEmptyMsg = "SEARCH RESULT RETURNED NOTHING";
      $(".search-results").append(buildErrorMessage(dataEmptyMsg));
    } else if (data.searchIdle) {
      //show search-brands and close
      showBrandSelection();
    } else {
      //close search-brands and close
      hideBrandSelection();

      //if there is data, iterate through them give them the propert names
      //makes it easier to assign as variables
      for (i = 0; i < data.length; i++) {
        var name = data[i]['name'];
        var id = data[i]['itemID'];
        var colors = data[i]['colors'];
        var img = data[i]['imgLink'];
        var releaseDay = data[i]['releaseDay'];
        var releaseMonth = data[i]['releaseMonth'];
        //create search result queries and attach them to html DOM to be displayed
        $(".search-results").append(buildSearchQuery(name, id, img, releaseMonth, releaseDay));
      }
    }
  }).fail(function(data) {
    //hide search by brand section
    hideBrandSelection();

    var dataRetreivalFailure = "DATA RETRIEVAL FAILED. CONTACT ADMINISTRATOR.";
    $(".search-results").append(buildErrorMessage(dataRetreivalFailure));
  });

  //add or delete shoe favorite to user preferences
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

  //function to build search query
  function buildSearchQuery(name, id, img, releaseMonth, releaseDay) {
    var releaseDate = releaseMonth + " " + releaseDay;
    var imgLink = "./" + img + "/1.jpg";
    var releaseDateHeader =  $('<h3/>', {});
    var shoeName = $('<h1/>', {});

    var queryParamObj = {
      name: name,
      id: id
    }

    var shoeDateContainer = $('<div/>', {
      class: "shoe-date-container"
    });

    var shoeUrlReference = $('<a/>', {
      href: buildUrlProductLink("sneaker.php", queryParamObj)
    });

    var imgLink = $('<img/>', {
      src: imgLink,
      alt: name
    });

    releaseDateHeader.text(releaseDate);
    shoeName.text(name);

    shoeDateContainer.append(releaseDateHeader, imgLink, shoeName);
    shoeUrlReference.append(shoeDateContainer);
    return shoeUrlReference;
  }

  //function to build link to sneaker page
  function buildUrlProductLink(page, queryObj) {
    return page + "?" + $.param(queryObj);
  }

  //building the error class
  function buildErrorMessage(msg) {
    var errorMsg = $('<p/>', {
      class: "error-msg"
    });

    errorMsg.text(msg);
    return errorMsg;
  }

  function showBrandSelection() {
    $(".search-brands").show();
    $(".close").show();
  }

  function hideBrandSelection() {
    $(".search-brands").hide();
    $(".close").hide();
  }
});
