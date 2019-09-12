import {defaultMainState} from './index';
import {types} from '../actions/index';

const actions=types;

export function main(state=defaultMainState,action){
    switch(action.type){
        case actions.REQUEST_DATA_FROM_SERVER:
            return {...state,isFetching:true};
        case actions.RECEIVE_SHORTCODE_HASH:
            return {...state,isFetching:false};
        case actions.RECEIVE_DELETE_SHORTCODE_ACCEPT:
            return {...state,isFetching:false}
        case actions.RECEIVE_POSTS_LIST:
            return {...state,isFetching:false};
        case actions.RECEIVE_ERROR:
            return {...state,isFetching:false};
        case actions.SHOW_MESSAGE:
            return {...state,message:{status:action.status,text:action.text}}
        case actions.POST_WAS_UPDATED:
            return {...state,isFetching:false,needToSave:false}
        case actions.DELETE_SHORTCODE:
        case actions.STOP_EDITING_SHORTCODE:
            return {...state,needToSave:true}
        
        default:
            return state;
    }
}