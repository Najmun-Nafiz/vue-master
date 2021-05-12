import { http, httpFile } from './http_service';


export function getCategory(page) {
    return http().get(`categories?page=${page}`);
}

export function createCategory(data) {
    return httpFile().post('categories', data);
}

export function updateCategory(id, data) {
    return httpFile().post(`categories/${id}`, data);
}

export function destroyCategory(id) {
    return http().delete(`categories/${id}`);
}

export function searchCategory(queryField, query, page) {
    return http().get(`search/categories/${queryField}/${query}?page=${page}`);
}