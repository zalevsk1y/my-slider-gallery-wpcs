import React from 'react';
import {SelectGroup} from '../components/SelectGroup';
import HorizontalTabPanel from '../components/HorizontalTabPanel';

import VerticalTabPanel from '../components/VerticalTabPanel'

import {getPostsListFromServer,showMessage} from '../actions/main';
import {getPostDataFromServer} from '../actions/post-data';
import Message from './Message';
import SideBar from './SideBar';
import { connect } from 'react-redux';
import IntroCard from '../components/cards/IntroCard';
import {getNonce} from '@my-gallery/helpers'

export class Main extends React.Component{
    constructor(props){
        super(props);
        this.selectPost=this.selectPost.bind(this);

        this.init();
    }
    init(){
        this.props.getPostsList();
        this.props.selectedPost&&this.props.getPostData(this.props.selectedPost);
    }
    selectPost(postId){
        //!this.props.isFetching&&this.props.getPostFromServer(post);
        if(this.props.needToSave){
            const message=[
                <p>You have unsaved changes.Please save or <a href={this.getRedirectLink(postId)}>continue</a></p>
            ]
            this.props.showMessage('Warning',message);
            return;
        }
        if(postId==-1) 
        {
            this.props.showMessage('Warning','Please select post');
            return;
        }
        this.redirectToPage(postId);
        
    }
    getRedirectLink(postId){
        const regex=/\&post\=[\d]+/g,
        url=window.location.href.replace(regex,'');
        return url+'&post='+encodeURI(postId);
    }
    redirectToPage(postId){
        
        window.location.href =this.getRedirectLink(postId);
    }
    getSelectedIndex(){
    
        return this.props.selectedPost||-1;
    }
    render(){
        return (
            <div className='container pl-5 pl-sm-2 pl-md-2 pl-lg-2 pl-xl-2'>
                <Message />
                <div className="py-1 py-lg-4">
                    <h1 className="wp-heading-inline">Add new gallery</h1>
                </div>
                
                <div className="my-gallery-content-main d-flex flex-column-reverse flex-sm-column-reverse flex-md-column-reverse flex-lg-row flex-xl-row pr-4 pr-sm-0">
                        <div className="my-gallery-content-left col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8  p-0">
                            <div>
                                <SelectGroup options={this.props.posts} selected={this.getSelectedIndex()} onSelect={this.selectPost} />
                            </div>
                            {(this.props.selectedPost===false&&<IntroCard />)}
                            {(this.props.selectedPost!==false&&<HorizontalTabPanel />)}
                            {(this.props.selectedShortcode!==false&&<VerticalTabPanel />)}
                    {
                        //my-gallery-content-left
                    }
                     </div>

                     <SideBar />
                {
                    // my-gallery-content-main
                }
                </div>
              
            </div>

        )
    }
}

function mapStateToProps(state){
    const post=state.route.post,
          selectedShortcode=state.postData?state.postData.selectedShortcode:false,
          needToSave=state.main.needToSave;
    return{
        isFetching:state.main.isFetching,
        posts:state.posts,
        selectedShortcode,
        selectedPost:post,
        needToSave
 
    }
}
function mapDispatchToProps(dispatch){
    return {
        getPostsList:()=>{
            const nonce=getNonce('addGallery');
            dispatch(getPostsListFromServer({dispatch,nonce}));
        },
        getPostData:(postId)=>{
            const nonce=getNonce('addGallery');
            dispatch(getPostDataFromServer({dispatch,nonce,postId}));
        },
        showMessage:(status,text)=>{
            dispatch(showMessage({status,text}))
        }
 
    }
}

export default connect(mapStateToProps,mapDispatchToProps)(Main);

