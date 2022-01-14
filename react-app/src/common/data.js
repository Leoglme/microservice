const userConnected = {
    id: 4,
    name: 'Léo Glme',
    image: '/userPics/02m.jpg'
}


const users = [
    {
        id: 1,
        name: 'ingrid Krol',
        image: '/userPics/03w.jpg'
    },
    {
        id: 2,
        name: 'Thomas Hayes',
        image: '/userPics/03m.jpg'
    },
    {
        id: 3,
        name: 'colddecember',
        image: '/userPics/04w.jpg'
    }
]


const conversations = [
    {
        id: 1,
        name: 'Andy',
        messages: [
            {
                sender: {
                    id: 1,
                    name: 'andy beverly',
                    image: '/userPics/01m.jpg'
                },
                content: {
                    message: "sure ! let's do it",
                    audio: null,
                    media: null
                },
                isTyping: {
                    name: 'Andy'
                },
            }
        ],
        notifications: 2,
        updated_at: '2021-12-18T08:32:00Z'
    },
    {
        id: 2,
        name: 'Caterina',
        messages: [
            {
                sender: {
                    id: 1,
                    name: 'andy beverly',
                    image: '/userPics/01w.jpg'
                },
                content: {
                    message: null,
                    audio: true,
                    media: null
                },
                isTyping: false
            }
        ],
        notifications: 0,
        updated_at: '2021-12-18T08:32:00Z'
    },
    {
        id: 3,
        name: 'Chat',
        messages: [
            {
                sender: {
                    id: 1,
                    name: 'Scott',
                    image: '/userPics/04m.jpg'
                },
                content: {
                    message: "Hey guys! Have a great working week!",
                    audio: null,
                    media: null
                },
                isTyping: false
            },
            {
                sender: {
                    id: 2,
                    name: 'Jennifer',
                    image: '/userPics/05w.jpg'
                },
                content: {
                    message: "Yo! I have a gret news for you all. Can i use voice message ?",
                    audio: null,
                    media: null
                },
                isTyping: false
            },
            {
                sender: {
                    id: 2,
                    name: 'Jennifer',
                    image: '/userPics/05w.jpg'
                },
                content: {
                    message: null,
                    audio: true,
                    media: null,
                },
                isTyping: false
            },
            {
                sender: {
                    id: 2,
                    name: 'Jennifer',
                    image: '/userPics/05w.jpg'
                },
                content: {
                    message: null,
                    audio: null,
                    media: [
                        {
                            type: 'image',
                            url: '/media/media1.jpg'
                        },
                        {
                            type: 'image',
                            url: '/media/media2.jpg'
                        }
                    ]
                },
                isTyping: false
            },
            {
                sender: userConnected,
                content: {
                    message: "I see you're really enjoying your holiday, it's great",
                    audio: null,
                    media: null
                },
                isTyping: false
            }
        ],
        notifications: 0,
        updated_at: '2021-12-18T08:32:00Z'
    },
    {
        id: 4,
        name: 'likeastorm',
        messages: [
            {
                sender: {
                    id: 1,
                    name: 'andy beverly',
                    image: '/userPics/02w.jpg'
                },
                content: {
                    message: null,
                    audio: null,
                    media: [
                        {
                            type: 'image',
                            url: ''
                        },
                        {
                            type: 'image',
                            url: ''
                        },
                        {
                            type: 'image',
                            url: ''
                        },
                        {
                            type: 'file',
                            url: ''
                        },
                        {
                            type: 'file',
                            url: ''
                        }
                    ]
                },
                isTyping: false
            }
        ],
        notifications: 0,
        updated_at: '2021-12-18T08:32:00Z'
    }
]

const initialChat = conversations.find(e => e.id === 3);

export {conversations, userConnected, users, initialChat}
