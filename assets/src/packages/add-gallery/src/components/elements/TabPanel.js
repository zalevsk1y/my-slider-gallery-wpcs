import React from 'react';
/**
 * this class is parent for TabPanels.It uses to provide methods to child classes.
 */
export default class TabPanel extends React.Component{
    /**
     * Init function.
     * 
     * @param {object} props 
     */
    constructor(props){
        super(props)
        this.tabClickHandler=this.tabClickHandler.bind(this);
        
    }
    /**
     * Gets active tab name from array of tabs.
     * 
     * @returns {string} Name of active tab.
     */
    getActiveTabName(){
        var tabName;
        this.state.tabs.forEach(item=>{
            if(item.active)tabName=item.name;
        })
        return tabName
    }
    /**
     * Update status of Tabs. Change active tab on click.
     * 
     * @param {object} event Click event object. 
     */
    tabClickHandler(event){
        event.preventDefault();
        const tabId=event.target.dataset.tabId;
        const newTabState=this.state.tabs.map((item,key)=>{
            if(key==tabId){
                item.active=true;
            }else{
                item.active=false;
            }
            return item;
        })
        
        this.setState({tabs:newTabState});
    }
    render(){
        return (
            <div>
               
            </div>
            
        )
    }
}