$(document).ready(function() {

     // dekstop searchbox

     $("#tooglesearchbox").click(function() {
          $("#searchbox").slideDown(300);
          $("#searchresults").delay(350).slideDown(200);
     });

     $("#searchboxclose").click(function() {
          $("#searchbox").delay(350).slideUp(300);
          $("#searchresults").slideUp(200);
     });

     // mobile new post modal

     $("#toogleMobileNewPost").click(function() {
          $("#mobileNewPostModal").slideToggle(800, function() {
               $("#mobileNewPostModal").css("display", "block");
          });
     });

     $("#closeMobileNewPost").click(function() {
          $("#mobileNewPostModal").slideToggle(800, function() {
               $("#mobileNewPostModal").css("display", "none");
          });
     });

     // mobile searchbox

     $("#tooglesearchbox-mobile").click(function() {
          $("#searchbox-mobile").slideDown(300);
          $("#searchresults-mobile").delay(350).slideDown(200);
     });

     $("#searchboxclose-mobile").click(function() {
          $("#searchresults-mobile").slideUp(800);
          $("#searchbox-mobile").delay(800).slideUp(800);
     });

     // mobile left side nav

     $("#toogleLeftSideNav").click(function() {
          $("#sitenav.mobile.left").css("left", "0");
     });

     $("#closeMobileLeftNav").click(function() {
          $("#sitenav.mobile.left").css("left", "-400px");
     });

     // mobile searchbox & close left sidenab

     $("#tooglesearchbox-mobile2").click(function() {
          $("#sitenav.mobile.left").css("left", "-400px");
          $("#searchbox-mobile").slideDown(300);
          $("#searchresults-mobile").delay(350).slideDown(200);
     });

     // dekstop nav user dropdown menu

     $("#toogleUserNavDropdown").click(function() {
          $("#nav-dropdown-user").slideToggle(250);
     });

     // new post modal

     $("#closeNewPostModalDesktop").click(function() {
          $("#newpostmodalddesktop").fadeOut(200);
     });

     $("#newPostModalDesktop").click(function() {
          $("#newpostmodalddesktop").fadeIn(200);
          $("#newpostPostBody").trigger("select");
     });

     function readURL(input) {

          if (input.files && input.files[0]) {
               var reader = new FileReader();

               reader.onload = function(e) {
                    $('#newpostDesktopImg').attr('src', e.target.result);
               }

               reader.readAsDataURL(input.files[0]);
               }
          }
     $("#newpostPostImg").change(function() {
          readURL(this);
     });

     $("#newpostPostImg").change(function (){
          $("#newpostPostImg").hide();
     });

     // comment modals

     var commentBtns = document.getElementsByClassName("comments");
     for (var i = 0; i < commentBtns.length; i++) {
          commentBtns[i].onclick = function() {
               var comment = this.nextElementSibling;
               if (comment.style.display == "none") {
                    comment.classList.toggle("show");
               }else {
                    comment.classList.toggle("show");
               }
          }
     }

     $("#commentscloser1").click(function() {
          $("#commentscloser1").parent().parent().removeClass("show");
     });

     $("#commentscloser2").click(function() {
          $("#commentscloser2").parent().parent().removeClass("show");
     });

     // mobile profile modal info

     $("#toogleMobileInfoUserModal").click(function() {
          $("#mobileProfileInfoModal").slideDown(400);
     });

     $("#closeMobileProfileInfoMobile").click(function() {
          $("#mobileProfileInfoModal").slideUp(400);
     });
});
