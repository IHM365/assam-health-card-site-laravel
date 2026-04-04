import Swal from 'sweetalert2';

/**
 * Show success alert
 */
export function showSuccess(title, message = '') {
    return Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        confirmButtonColor: '#10b981',
    });
}

/**
 * Show error alert
 */
export function showError(title, message = '') {
    return Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        confirmButtonColor: '#ef4444',
    });
}

/**
 * Show info alert
 */
export function showInfo(title, message = '') {
    return Swal.fire({
        icon: 'info',
        title: title,
        text: message,
        confirmButtonColor: '#3b82f6',
    });
}

/**
 * Show warning alert
 */
export function showWarning(title, message = '') {
    return Swal.fire({
        icon: 'warning',
        title: title,
        text: message,
        confirmButtonColor: '#f59e0b',
    });
}

/**
 * Show confirmation dialog
 */
export function showConfirm(title, message = '', confirmButtonText = 'Yes', cancelButtonText = 'Cancel') {
    return Swal.fire({
        icon: 'question',
        title: title,
        text: message,
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#ef4444',
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
    });
}

/**
 * Show loading alert
 */
export function showLoading(title = 'Loading...') {
    return Swal.fire({
        title: title,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: (modal) => {
            Swal.showLoading();
        },
    });
}

/**
 * Close the current alert
 */
export function closeAlert() {
    return Swal.close();
}
