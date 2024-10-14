import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import 'flowbite';



// Function to toggle the user fields visibility
// Function to toggle the user fields visibility
// function toggleAccountFields() {
//     const checkbox = document.getElementById('creerCompte');
//     const userFields = document.getElementById('userFields');
//     console.log('Checkbox toggled, checked:', checkbox.checked); // Debugging line
//     userFields.style.display = checkbox.checked ? 'block' : 'none';
// }

const checkbox = document.getElementById('creerCompte');
    const userFields = document.getElementById('userFields');

    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            userFields.classList.remove('hidden'); // Show user fields
        } else {
            userFields.classList.add('hidden'); // Hide user fields
        }
    });

// Ensure DOM is fully loaded before adding the event listener
// document.addEventListener('DOMContentLoaded', () => {
//     const checkbox = document.getElementById('creerCompte');
//     if (checkbox) {
//         // Attach event listener to checkbox to toggle user fields when clicked
//         checkbox.addEventListener('change', toggleAccountFields);
//     }
// });




console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
