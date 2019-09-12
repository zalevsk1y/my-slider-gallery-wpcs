import {posts} from './posts';
import {main} from './main';
import {postData} from './post-data'
import {combineReducers} from "redux"
import {route} from './route'
export const defaultMainState={
    error:0,
    isFetching:false,
    needToSave:false
}
export const defaultPostsState=[
    {
        title:"Loading...",
        id:-1
    }
]

export const defaultShortcode={   
    status:"draft",
    code:{
        ids:'',
        config:'',
        misc:''
    },
    images:[],
    settings:{
        misc:{
        title:""
        },
        config:{
        galleryMode:true,
        loop:false,
        thumbsNumber:6,
        items:1
        }
    },
    _originalCode:null
}
export const defaultPostsDate={
    selectedShortcode:false,
    currentEditShortcode:false
}

export const defaultPostState=[];

export default combineReducers({main,posts,postData,route})