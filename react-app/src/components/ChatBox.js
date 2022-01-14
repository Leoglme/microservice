import React from 'react';
import Messages from "./Chat/Messages";
import HeaderChat from "./Chat/HeaderChat";
import MessageField from "./Chat/MessageField";

function ChatBox({users, currentChat}) {
    return (<>
        <HeaderChat users={users} title={currentChat.name}/>
        <Messages currentChat={currentChat}/>
        <MessageField/>
    </>);
}

export default ChatBox;
