import {types} from '../actions/index';

export function route(state={post:false},action){
    switch (action.type){
        case types.SET_ROUTE:
        return {
            post:action.post
        }
        default:
        return {...state}
    }
}