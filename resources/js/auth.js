// auth.js
export function checkIfUserIsAuthenticated() {
    const token = localStorage.getItem('token'); // I-check kung may token sa local storage

    console.log('token',token)
    return !!token; // I-return ang resulta ng pag-check kung mayroong token o wala
}
