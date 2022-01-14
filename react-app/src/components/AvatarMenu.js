import React, {useState} from 'react';
import Avatar from "./common/Avatar";
import {userConnected} from "../common/data";
import {ReactComponent as Logout} from '../assets/icons/curved/Logout.svg';
import {ReactComponent as User} from '../assets/icons/curved/User.svg';
import clsx from "clsx";
import { useNavigate } from 'react-router-dom';

function AvatarMenu(props) {
    const [open, setOpen] = useState(false)
    const navigate = useNavigate();

    const handleMenu = () => {
        setOpen(!open)
    }

    const items = [
        {
            name: 'Profile',
            icon: <User/>,
            onClick: () => navigate('profile')
        },
        {
            name: 'Logout',
            icon: <Logout/>,
            onClick: () => navigate('login')
        }
    ]

    return (<>
        <div style={{position: "absolute", bottom: 24, left: 28}}>
            <div className={clsx("avatar-menu", open ? 'active' : null)}>
                <ul>
                    {items.map(item => {
                        return <li className={'menu-item'} onClick={item.onClick} key={item.name}>
                            {item.icon}{item.name}
                        </li>
                    })}
                </ul>
            </div>

            <div className="start" style={{gap: 12}}>
                <div className={"border-avatar"} onClick={handleMenu}>
                    <Avatar
                        image={userConnected.image}
                        user={userConnected}
                        size={42}
                        radius={15}
                    />
                </div>
                <h5 className="text-h5">{userConnected.name}</h5>
            </div>
        </div>
    </>);
}

export default AvatarMenu;
