import {types} from '../actions/index';
import {defaultPostsState} from '../reducers/index'

const actions=types;

export function posts(state=defaultPostsState,action){
    switch (action.type){
        case actions.RECEIVE_POSTS_LIST:
            action.posts.unshift({title:"Choose post...",id:-1})
            return action.posts;
        default:
            return state;
    }
}