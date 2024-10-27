const form=document.getElementById('form')
const firstname_input=document.getElementById('firstname-input')
const email_input=document.getElementById('email-input')
const password_input=document.getElementById('password-input')
const repassword_input=document.getElementById('repassword-input')
const error_msg=document.getElementById('error-message')


/*form.addEventListener('submit',(e) => 
{
    // e.preventDefault()
    let errors = []

    if(firstname_input)
    {
        //we are in sign up page
        errors=getSignupFormErrors(firstname_input.value, email_input.value, password_input.value, repassword_input.value)
    }
    else
    {
        //login page
        errors=getLoginFormErrors(email_input.value, password_input.value)
    }

    if(errors.length>0)
    {
        e.preventDefault()
        error_msg.innerText=errors.join(". ")
    }
    
})
    */

form.addEventListener('submit', (e) => {
    let errors = [];

    if (firstname_input) {
        // We are in the sign-up page
        errors = getSignupFormErrors(firstname_input.value, email_input.value, password_input.value, repassword_input.value);
    } else {
        // Login page
        errors = getLoginFormErrors(email_input.value, password_input.value);
    }

    console.log(errors); // Log the errors to the console for debugging

    // Remove the preventDefault for testing
    // e.preventDefault(); // Temporarily comment this line

    if (errors.length > 0) {
        e.preventDefault(); // Prevent form submission if there are errors
        error_msg.innerText = errors.join(". ");
    } else {
        error_msg.innerText = ''; // Clear error message if no errors
    }
});


function getSignupFormErrors(firstname,email,password,repassword)
{
    let errors=[]
    if(firstname=='' || firstname==null)
    {
        errors.push('Firstname is required')
        firstname_input.parentElement.classList.add('incorrect')
    }
    if(email=='' || email==null)
    {
        errors.push('Email is required')
        email_input.parentElement.classList.add('incorrect')
    }
    if(password=='' || password==null)
    {
        errors.push('Password is required')
        password_input.parentElement.classList.add('incorrect')
    }
    if(password.length<8)
    {
        errors.push('Password must have alteast 8 characters')
        password_input.parentElement.classList.add('incorrect')
    }
    if(repassword!=password)
        {
            errors.push('Password does not match')
            password_input.parentElement.classList.add('incorrect')
            repassword_input.parentElement.classList.add('incorrect')
        }
    return errors
            
    
}
function getLoginFormErrors(email,password)
{
    let errors=[]
    if(email=='' || email==null)
    {
        errors.push('Email is required')
        email_input.parentElement.classList.add('incorrect')
    }
    if(password=='' || password==null)
    {
        errors.push('Password is required')
        password_input.parentElement.classList.add('incorrect')
    }
    return errors
}

const allInput=[firstname_input,email_input,password_input,repassword_input].filter(input=>input!=null)
allInput.forEach(input=>
{
    input.addEventListener('input',()=>
    {
        if(input.parentElement.classList.contains('incorrect'))
        {
            input.parentElement.classList.remove('incorrect')
            error_msg.innerText=' '
        }
    })
}
)