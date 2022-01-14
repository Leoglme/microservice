import React from 'react';
import RecentMessage from "./RecentMessage";
import SearchBar from "../common/SearchBar";
import {conversations} from "../../common/data";


const List = (
    conversations.map((data, index) => {
        return (<RecentMessage key={index} discussion={data} active={index === 2}/>)
    })
)

function RecentMessages(props) {
    return (<>
        <SearchBar/>
        <div className="column center w100">
            {List}
        </div>
    </>);
}

export default RecentMessages;
