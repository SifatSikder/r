import axios from 'axios';

// Common headers for API requests
const headers = {
    'Content-Type': 'application/json; charset=utf-8',
    'x-api-key': '_@@mot4ai-secu2023re@@_'
};

// Handle successful API responses
const responseHandler = (response, callback) => {
    if (response.status === 200) {
        callback(response.data);
    }
};

// Handle API errors
const errorHandler = (err) => {
    const errorCode = parseInt(err.toLocaleString().replace(/\D/g, ""));
    if (errorCode === 401) {
        window.location.reload();
    }
};

// ApiService object with various HTTP request methods
const ApiService = {
    // POST method with JSON data
    POST: (url, param, callback) => {
        axios.post(url, param, { headers: headers })
            .then((response) => responseHandler(response, callback))
            .catch((err) => errorHandler(err));
    },

    // POST method with FormData for file uploads
    POST_FORM_DATA: (url, formData, callback) => {
        const mediaHeaders = {
            'Content-Type': 'multipart/form-data',
            'x-api-key': '_@@mot4ai-secu2023re@@_'
        };
        axios.post(url, formData, { headers: mediaHeaders })
            .then((response) => responseHandler(response, callback))
            .catch((err) => errorHandler(err));
    },

    // PUT method with JSON data
    PUT: (url, data, callback) => {
        axios.put(url, data, { headers: headers })
            .then((response) => responseHandler(response, callback))
            .catch((err) => errorHandler(err));
    },

    // GET method
    GET: (url, callback) => {
        axios.get(url, { headers: headers })
            .then((response) => responseHandler(response, callback))
            .catch((err) => errorHandler(err));
    },

    // GET method
    DELETE: (url, callback) => {
        axios.delete(url, { headers: headers })
            .then((response) => responseHandler(response, callback))
            .catch((err) => errorHandler(err));
    },

    // POST method for file uploads
    UPLOAD: (url, media, callback) => {
        const mediaHeaders = {
            'Content-Type': 'multipart/form-data',
            'x-api-key': '_@@mot4ai-secu2023re@@_'
        };
        axios.post(url, media, { headers: mediaHeaders })
            .then((response) => responseHandler(response, callback))
            .catch((err) => errorHandler(err));
    },

    // Custom error handler for form validation errors
    ErrorHandler(errors) {
        $('.is-invalid').removeClass('is-invalid');
        $('.error-report').html('');
        $('.error-report-g').html('');
        $.each(errors, (field, message) => {
            if (field === 'error') {
                $('.error-report-g').html('<p class="alert alert-danger">' + message + '</p>');
            } else {
                $('[name=' + field + ']').addClass('is-invalid');
                $('[name=' + field + ']').closest('.form-group').find('.error-report').html(message);
            }
        });
    },

    // Clear form validation errors
    ClearErrorHandler() {
        $('.is-invalid').removeClass('is-invalid');
        $('.error-report').html('');
    }
};

export default ApiService;
