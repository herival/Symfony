/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

const $ = require('jquery');
require('bootstrap');


let suppr = document.getElementsByClassName('suppr')[0];
console.log (suppr);

suppr.onclick = function() {
    let confirmation = confirm("Voulez-vous supprimer cet artiste");
    if (confirmation == true) { }
    else {}
    console.log("message");
}

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

// alert ("message");
