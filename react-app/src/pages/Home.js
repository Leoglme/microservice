import React, {useEffect, useState} from 'react';
import MembersList from "../components/MembersList";
import ChatBox from "../components/ChatBox";
import MessagesList from "../components/MessagesList";
import AvatarMenu from "../components/AvatarMenu";
import {initialChat, users} from "../common/data";

function Home(props) {
    const [currentChat, setCurrentChat] = useState(initialChat)

    return (<>
        <div className="layout-left column_container">
            <MessagesList/>
            <AvatarMenu/>
        </div>
        <div className="layout-center">
            <ChatBox users={users} currentChat={currentChat}/>
        </div>
        <div className="layout-right">
            <MembersList users={users}/>
        </div>
    </>);
}

export default Home;
