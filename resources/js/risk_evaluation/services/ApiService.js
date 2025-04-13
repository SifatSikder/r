import axios from 'axios'
let headers = {
    'Content-Type': 'application/json; charset=utf-8',
    'x-api-key': '_@@mot4ai-secu2023re@@_'
};
const ApiService = {
    POST: (url, param, callback) => {
        axios.post(url, param, {headers: headers}).then((response) => {
            if (response.status === 200) {
                callback(response.data);
            }
        }).catch(err => {
            const error_code = parseInt(err.toLocaleString().replace(/\D/g, ""));
            if (error_code === 401) {
                window.location.reload();
            }
        })
    },
    GET: (url, callback) => {
        axios.get(url, {headers: headers}).then((response) => {
            if (response.status === 200) {
                callback(response.data);
            }
        }).catch(err => {
            const error_code = parseInt(err.toLocaleString().replace(/\D/g, ""));
            if (error_code === 401) {
                window.location.reload();
            }
        })
    },
    UPLOAD: (url, media, callback) => {
        const MediaHeaders = {
            "Content-Type": "multipart/form-data",
            'x-api-key': '_@@mot4ai-secu2023re@@_'
        };
        axios.post(url, media, {headers: MediaHeaders}).then((response) => {
            if (response.status === 200) {
                callback(response.data);
            }
        }).catch(err => {
            const error_code = parseInt(err.toLocaleString().replace(/\D/g, ""));
            if (error_code === 401) {
                window.location.reload();
            }
        })
    },
    ErrorHandler(errors) {
        $('.is-invalid').removeClass('is-invalid');
        $('.error-report').html('');
        $('.error-report-g').html('');
        $.each(errors, (i, v) => {
            if (i === 'error') {
                $('.error-report-g').html('<p class="alert alert-danger">' + v + '</p>')
            } else {
                $('[name=' + i + ']').addClass('is-invalid');
                $('[name=' + i + ']').closest('.form-group').find('.error-report').html(v);
            }
        });
    },
    ClearErrorHandler() {
        $('.is-invalid').removeClass('is-invalid');
        $('.error-report').html('');
    }
}
export default ApiService;
