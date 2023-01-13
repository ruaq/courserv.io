import './bootstrap';

import '@fortawesome/fontawesome-free/scss/fontawesome.scss';
import '@fortawesome/fontawesome-free/scss/regular.scss';
import '@fortawesome/fontawesome-free/scss/solid.scss';
import '@fortawesome/fontawesome-free/scss/brands.scss';

import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

import * as Turbo from "@hotwired/turbo"

import 'livewire-turbolinks'

import 'friendly-challenge/widget'

import 'flatpickr'
const flatpickr = require("flatpickr");

import 'flatpickr/dist/l10n/de.js'
const German = require("flatpickr/dist/l10n/de.js").default.de;
