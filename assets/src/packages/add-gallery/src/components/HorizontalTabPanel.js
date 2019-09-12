import React from 'react';
import TabPanel from './elements/TabPanel'
import HorizontalTabsMenu from './tab-menus/HorizontalTabsMenu'
import SelectImagePane from './panes/SelectImagePane';
import ExternalSourcePane from './panes/ExternalSourcePane';

/**
 * Horizontal oriented Tab Panel.Consist of two parts TabMenu and Panes.  
 */
export default class HorizontalTabPanel extends TabPanel{
    /**
     * Init function.
     * 
     * @param {object} props 
     */
    constructor(props){
        super(props)
        this.state={tabs:[
            {
                name:'Select Image',
                active:true
            },
            {
                name:'External Source',
                active:false
            }
        ]}
    }
    /**
     * Render selected pane. 
     * 
     * @param {object} paneName Name of Pane.  
     */
    paneRender({paneName}){
        switch(paneName){
            case 'Select Image':
            return <SelectImagePane />
            case 'External Source':
            return <ExternalSourcePane />
        }
    }
 
    render(){
        return (
            <div>
                <div className="mt-2 mt-md-2">
                    <HorizontalTabsMenu className="nav nav-tabs" tabsList={this.state.tabs} ariaName="ImageSelect" onClick={this.tabClickHandler} />
                </div>
                <div className="tab-content col-12">
                    <this.paneRender paneName={this.getActiveTabName()} />
                </div>
            </div>
            
        )
    }
}

