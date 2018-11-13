$(document).ready(function() {
  /*
    form scripts to switch between register and sign in
  */
  $(".register-btn").click(function() {
    $(".log-in").hide();
    $(".log-in-redirect").show();

    $(".register").show();
    $(".register-redirect").hide();
  });

  $(".log-in-btn").click(function() {
    $(".log-in").show();
    $(".log-in-redirect").hide();

    $(".register").hide();
    $(".register-redirect").show();
  });

  //go back one page
  // $(".back").click(function() {
  //   history.back(-1);
  // });

  //checks to see if a search input is focused
  $("input[name=search-input]").focus(function() {
    $(".search-brands").hide();
    $(".close").hide();
  });

  $(".close").click(function() {
    $(".search-brands").hide();
    $(".close").hide();
  })

  $('#search-by-brand').click(function() {
    $(".search-brands").show();
    $(".close").show();
  })

})
