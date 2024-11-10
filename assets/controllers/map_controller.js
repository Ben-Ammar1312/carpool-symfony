// assets/controllers/map_controller.js
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.initMap();
    }

    initMap() {
        const defaultLocation = { lat: 40.7128, lng: -74.0060 }; // Example: New York City

        const map = new google.maps.Map(this.element, {
            center: defaultLocation,
            zoom: 12,
        });

        // Add more Google Maps functionality as needed
    }
}