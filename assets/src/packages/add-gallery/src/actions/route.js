import {types} from './index';

export function setRoute(postId){
    return {
        type: types.SET_ROUTE,
        post:postId
            ? decodeURIComponent(postId)
            : false
    }
}