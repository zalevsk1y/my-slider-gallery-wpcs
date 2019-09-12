import {types} from '../actions/index';
import {defaultPostsDate,defaultShortcode} from './index';
import {generateNewIds,generateNewConfig,generateNewMisc,cloneObject} from '@my-gallery/helpers';

const actions=types;

export function postData(state=false,action){
    switch (action.type){
        case actions.RECEIVE_POST_DATA:
           
            return {...defaultPostsDate,id:action.postId,shortcodes:action.postData};
        case actions.CREATE_NEW_SHORTCODE:
            return {
                ...state,
                selectedShortcode:state.shortcodes.length,
                shortcodes:[...state.shortcodes,defaultShortcode]
            };
        case actions.SELECT_SHORTCODE:
            return {
                ...state,
                selectedShortcode:action.shortcodeId,
                shortcodes:state.shortcodes.map((item,key)=>{
                    return key==action.shortcodeId?{...item,
                    _originalState:cloneObject(item)
                    }:{...item}
                })
            }
        case actions.UNSELECT_SHORTCODE:
            return{...state,
                selectedShortcode:false,
                shortcodes:state.shortcodes.map((item,key)=>{
                    return (key==action.shortcodeId&&item._originalState)?item._originalState:{...item}  
                })
            }
        case actions.STOP_EDITING_SHORTCODE:
            delete action.shortcode._originalState;
            return {
                ...state,
                selectedShortcode:false,
                shortcodes:state.shortcodes.map((item,key)=>{
                    if(key==action.shortcodeId){
                        return {...action.shortcode,
                            status:item.status==='saved'?'changed':item.status,
                        }
                    }
                    return item;
                })
            }
        case actions.DELETE_UNSAVED_SHORTCODE:
            return {...state,
                shortcodes:state.shortcodes.slice(0,-1),
                selectedShortcode:false
            }
        case actions.DELETE_SHORTCODE:
            return {...state,
                shortcodes:state.shortcodes.map((item,key)=>{
                    return {...item,status:key==action.shortcodeId?'deleted':item.status}
                })
            }
        case actions.SET_NEW_IMAGES_ORDER:
        var ids=generateNewIds(action.newOrder);
            return {...state,
                shortcodes:state.shortcodes.map((item,key)=>{
                        if(key==action.shortcodeId){
                            return {...item,
                                    images:action.newOrder,
                                    code:{...item.code,ids}
                                };
                        }
                        return item;
                    })
                };
        case actions.UPDATE_SHORTCODE_IMAGES:
            var ids=generateNewIds(action.images);
            return {...state,
                shortcodes:state.shortcodes.map((item,key)=>{
                    if(key==action.shortcodeId){
                        return {...item,
                                images:action.images,
                                code:{...item.code,ids}
                            };
                    }
                    return item;
                })
            }
        case actions.UPDATE_CONFIG:
            const config=generateNewConfig(action.config)
            return {...state,
                shortcodes: state.shortcodes.map((item,key)=>{
                    if(key==action.shortcodeId){
                        return {...item,
                                    settings:{...item.settings,
                                        config:action.config},
                                        code:{...item.code,config}
                        }
                    }
                    return item;
                })
            } 
        case actions.UPDATE_MISC:
        const misc=generateNewMisc(action.misc)
            return {...state,
                shortcodes: state.shortcodes.map((item,key)=>{
                    if(key==action.shortcodeId){
                        return {...item,
                                    settings:{...item.settings,
                                        misc:action.misc},
                                    code:{...item.code,misc}
                        }
                    }
                    return item;
                })
        } 
        default:
            return state;
    }
}

