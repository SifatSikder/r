// Import Axios for making HTTP requests
import axios from 'axios';

// Define default headers for API requests
let headers = {
    'Content-Type': 'application/json; charset=utf-8',
    'x-api-key': '_@@mot4ai-secu2023re@@_'
};

// ApiService object to handle various types of HTTP requests
const ApiService = {
    // Method for handling POST requests
    POST: (url, param, callback) => {
        axios.post(url, param, { headers: headers }).then((response) => {
            if (response.status === 200) {
                callback(response.data);
            }
        }).catch(err => {
            // Handle unauthorized error (401) by reloading the window
            const error_code = parseInt(err.toLocaleString().replace(/\D/g, ""));
            if (error_code === 401) {
                window.location.reload();
            }
        });
    },
    // Method for handling GET requests
    GET: (url, callback) => {
        axios.get(url, { headers: headers }).then((response) => {
            if (response.status === 200) {
                callback(response.data);
            }
        }).catch(err => {
            // Handle unauthorized error (401) by reloading the window
            const error_code = parseInt(err.toLocaleString().replace(/\D/g, ""));
            if (error_code === 401) {
                window.location.reload();
            }
        });
    },
    // Method for handling file upload requests
    UPLOAD: (url, media, callback) => {
        const MediaHeaders = {
            "Content-Type": "multipart/form-data",
            'x-api-key': '_@@mot4ai-secu2023re@@_'
        };
        axios.post(url, media, { headers: MediaHeaders }).then((response) => {
            if (response.status === 200) {
                callback(response.data);
            }
        }).catch(err => {
            // Handle unauthorized error (401) by reloading the window
            const error_code = parseInt(err.toLocaleString().replace(/\D/g, ""));
            if (error_code === 401) {
                window.location.reload();
            }
        });
    },
    // Method for handling API error responses and displaying them in the form
    ErrorHandler(errors) {
        $('.is-invalid').removeClass('is-invalid');
        $('.error-report').html('');
        $('.error-report-g').html('');
        $.each(errors, (i, v) => {
            if (i === 'error') {
                $('.error-report-g').html('<p class="alert alert-danger">' + v + '</p>');
            } else {
                $('[name=' + i + ']').addClass('is-invalid');
                $('[name=' + i + ']').closest('.form-group').find('.error-report').html(v);
            }
        });
    },
    // Method for clearing error indicators and messages in the form
    ClearErrorHandler() {
        $('.is-invalid').removeClass('is-invalid');
        $('.error-report').html('');
    }
};

// Export the ApiService object for use in other modules
export default ApiService;
