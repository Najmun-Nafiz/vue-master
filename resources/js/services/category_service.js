import {http, httpFile} from './http_service';

export function getCategory() {
    return http().get('/categories');
}
export function createCategory(data) {
    return httpFile().post('/categories', data);
}
export function destroyCategory(id) {
    return http().delete(`categories/${id}`);
}