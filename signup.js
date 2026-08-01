// Sign Up page

const main= document.querySelector('.main');
const LoginLink=document.querySelector('.signInLink');
const RegisterLink=document.querySelector('.signUpLink');

RegisterLink.addEventListener('click',()=>{
    main.classList.add('active');
});
LoginLink.addEventListener('click',()=>{
    main.classList.remove('active');
});


// Wishlist Increase
