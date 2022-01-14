import React from 'react';
import {
    BrowserRouter as Router,
    Routes,
    Route
} from "react-router-dom";

import Profile from '../pages/Profile';
import Home from '../pages/Home';

function Index(props) {
    return (
        <Router>
            <Routes>
                <Route path="/" element={<Home />}/>
                <Route path="/profile" element={<Profile />}/>
            </Routes>
        </Router>
    );
}

export default Index;
