import {types} from './index';
import config from '@my-gallery/config';


const action=types;

export function requestDataFromServer(){
    return {
        type:action.REQUEST_DATA_FROM_SERVER
    }
}
export function receivePostsList(postsList){
    return {
        type:action.RECEIVE_POSTS_LIST,
        posts:postsList
    }
}
export function receiveDataFromServer(){
    return {
        type:action.RECEIVE_DATA_FROM_SERVER
    }
}
export function errorFetching (error){
    return {
        type:action.FETCH_ERROR,
        error
    }
}
export function showMessage({status,text}){
    return {
        type:action.SHOW_MESSAGE,
        status,
        text
    }
}



export function getPostsListFromServer ({dispatch,nonce}){
    dispatch(requestDataFromServer());
    return dispatch=>{ 
        return fetch(apiEndpoints.getPostsList,{
            method:"GET",
            headers:{
                'X-WP-Nonce':nonce
            }
        })
       .then(response=>response.json())
       .then((json)=>{
           if(json){
            dispatch(receivePostsList(JSON.parse(json)));
           }
       })
       .catch(error=>{
        dispatch(errorFetching(error))
    })
    }
}