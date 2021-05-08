import { http, httpFile } from './http_service';


export function getProduct() {
    return http().get('products');
}

export function allCategory() {
    return http().get('allcategory');
}

export function createProduct(data) {
    return httpFile().post('products', data);
}

export function updateProduct(id, data) {
    return httpFile().post(`products/${id}`, data);
}

export function destroyProduct(id) {
    return http().delete(`products/${id}`);
}