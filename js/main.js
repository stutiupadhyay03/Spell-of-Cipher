// ===========================navbar===================

function  navbar(){
$(document).ready(function() {


    $('.fa-bars').click(function() {
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('nav-toggle');
    });

    $(window).on('load scroll', function() {
        $('.fa-bars').removeClass('fa-times');
        $('.navbar').removeClass('nav-toggle');

        if ($(window).scrollTop() > 30) {
            $('.header').css({ 'background': '#6C5CE7', 'box-shadow': '0 .2rem .5rem rgba(0,0,0,.4)' ,'position':'fixed'});
        } else {
            $('.header').css({ 'background': 'none', 'box-shadow': 'none' });
        }
    });


    $('.accordion-header').click(function() {
        $('.accordion .accordion-body').slideUp();
        $(this).next('.accordion-body').slideDown();
        $('.accordion .accordion-header span').text('+');
        $(this).children('span').text('-');
    });



});

}

// =========login.php=====for login sign up transform ===and=type on sign up=================
function loginpage(){

        const loginText = document.querySelector(".title-text .login");
         const loginForm = document.querySelector("form.login");
         const loginBtn = document.querySelector("label.login");
         const signupBtn = document.querySelector("label.signup");
         const signupLink = document.querySelector("form .signup-link a");
      

         signupBtn.onclick = (()=>{
           loginForm.style.marginLeft = "-50%";
           loginText.style.marginLeft = "-50%";
            
         });

         loginBtn.onclick = (()=>{
           loginForm.style.marginLeft = "0%";
           loginText.style.marginLeft = "0%";
         });
         signupLink.onclick = (()=>{
           signupBtn.click();
           return false;
         });

var x=document.getElementById('signupstatus').innerHTML;        

if(x=="true"){
    document.getElementById('signup').checked = true;
    loginForm.style.marginLeft = "-50%";
    loginText.style.marginLeft = "-50%";
}      


}
function passcondition(){
    document.getElementById("pass_condition").style.display="block";
    // document.getElementById("heading").style.display="none";
}

function heading(){
    // document.getElementById("heading").style.display="flex";
    document.getElementById("pass_condition").style.display="none";
}

function select_solo(){
    
    document.getElementById("type").value= "solo_inactive";
    document.getElementById('solo').classList.add("active");
    var li = document.getElementById('team');
    if(li.className.search("active")>=0)
    {
        document.getElementById('team').classList.remove("active");
    }


}

function select_team(){
    
    document.getElementById("type").value= "team_leader_inactive";

    document.getElementById('team').classList.add("active");
    var l = document.getElementById('solo');
    if(l.className.search("active")>=0)
    {
        document.getElementById('solo').classList.remove("active");
    }
}

// function paymentshow(){
// document.getElementById("signupsuccess").style.display= "block";
// }


// =============================profile_setup.php======gender ================
function select_female()
{
    document.getElementById("gender").value= "female";
    girl = document.getElementById("female");
    girl.style.border ="3px solid black";
    boy = document.getElementById("male");
    boy.style.border ="0px solid transparent";
    girl.value="female";
    boy.value="";
}

function select_male()
{
    document.getElementById("gender").value= "male";
    boy = document.getElementById("male");
    boy.style.border ="3px solid black";
    girl = document.getElementById("female");
    girl.style.border ="0px solid transparent";
    boy.value="male";
    girl.value="";
}



// =========================team leader=======================

