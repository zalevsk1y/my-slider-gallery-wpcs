
import config from '@my-gallery/config';
import {myGalleryPlugin} from 'globals';
import {wp} from 'globals';

function shortcodeGutenberg(text) {
        /*
        * Gutenberg Editor dependencies
        * https://github.com/WordPress/gutenberg/tree/master/packages/data
        * activate save post button
        */
    const {dispatch} = wp.data,
        /**
         * Gutenberg createBlock 
         * https://github.com/WordPress/gutenberg/blob/master/packages/blocks/src/api/factory.js
         * List of Gutenberg core blok names 
         * https://gist.github.com/DavidPeralvarez/37c8c148f890d946fadb2c25589baf00
         */
          {createBlock} = wp.blocks,
          shortcodeBlock = createBlock('core/shortcode',{text})
    dispatch( 'core/block-editor' ).insertBlock(shortcodeBlock);
  
}

function shortcodeClassic(text) {
    return document
        .querySelector('#content_ifr')
        .contentDocument
        .querySelector('#tinymce');
}

export function shortcode(ids) {
    const text = '[my-gallery ids=' + ids + ']'; 
    const editorWindow = myGalleryPlugin.editor == 'gutenberg'
            ? shortcodeGutenberg(text)
            : myGalleryPlugin.editor == 'classic' && shortcodeClassic(text);
        
    editorWindow.innerHTML += '<br> ' + text;
}

/**
 *  Identifies type of using WP editor.
 *
 * @return string
 */

export function getEditorType() {
    const toolsContainerClassic = document.querySelector('#wp-content-editor-tools'),
        toolsContainerGutenberg = document.querySelector('.editor-inserter');
    if (toolsContainerClassic) {
        return 'classic';
    } else if (toolsContainerGutenberg) {
        return 'gutenberg';
    }

}


export function hashCode(str){
    var hash = 0,
    char;
    if (str.length == 0) return hash;
    for (var i = 0,end=str.length; i <end ; i++) {
        char = str.charCodeAt(i);
        hash = ((hash<<5)-hash)+char;
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;

}

export function cloneObject(object){
    const jsonObj=JSON.stringify(object);
    return JSON.parse(jsonObj);
}

export function uriToObject(uri){
    if (!uri) return {};
    const jsonParams='{\"'+uri.replace(/&/g,'","').replace(/=/g,'":"').replace(/\?/g,"")+'\"}';
    if(jsonParams){
        return JSON.parse(jsonParams);
    }
    return {};
}
export function logErrorToService(error, info){
    const parameters=config.emulateJSON?oldServerData({error,info}):newServerData({error,info});
    fetch(config.errorLogApi.report,parameters)
}
export function getLanguage(){
    const className=config.lang.class;
    return document.querySelector('.'+className).dataset['lang'].substring(0,2);
}

export function getNonce(page){
    const id=config.nonce[page].id,
          dataset=config.nonce[page].data;
    var nonce=document.getElementById(id).dataset[dataset];
    return nonce;
}

export function getUrlWithParams(params){
    const url=window.location.pathname+config.root;
    let search='';
    Object.keys(params).forEach(key => {
        search+='&'+key+'='+encodeURIComponent(params[key]);
    });
    return url+search;
    }

export function combineSubReducers(parentReducer,childReducerName,childReducer){
    return (state,action)=>{
        var mainState=parentReducer(state,action),
            childState=childReducer(mainState[childReducerName],action);
        mainState[childReducerName]={...childState};
        return {...mainState};
    }
}
export function uriToJson(uri){
    if (!uri) return {};
    const jsonParams='{\"'+uri.replace(/&/g,'","').replace(/=/g,'":"').replace(/\?/g,"")+'\"}';
    if(jsonParams){
        return JSON.parse(jsonParams);
    }
    return {};
}

export function generateNewIds(imagesArr){
    
    var ids=imagesArr.map(item=>{
        return item.id;
    }).join(',');
    return  'ids='+ids;
}
export function generateNewConfig(newConfig){
    var configCode=''
    for(var item in newConfig){
        if(!newConfig.hasOwnProperty(item)){
            continue;
        }
        configCode+=+newConfig[item];
    }
    return configCode?'config='+configCode:'';
}
export function generateNewMisc(newMisc){
    const title=newMisc.title
        return (title?'title=\"'+title+'\"':'');

}
export function oldServerData(data){
    const options= {
        method: 'POST',
        headers: {
        'Accept': 'application/x-www-form-urlencoded',
        'Content-Type': 'application/x-www-form-urlencoded',
        
        }
   }
   if (data){
        const paramName=Object.keys(data);
        var body='';
        paramName.forEach((item)=>{
                body=+body?'&'+encodeURIComponent(item)+'='+objectToUrlEncoded(data[item]):encodeURIComponent(item)+'='+objectToUrlEncoded(data[item]);
        });
        options.body=body;
    }
   return options;
}

export function newServerData(body){
   const options= {
       method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',

    },
   
   }
   if(body) options.body=JSON.stringify(body);
   return options;
}

function objectToUrlEncoded(obj){
    return encodeURIComponent(JSON.stringify(obj))
}

let nonceSettingsPage=null;

