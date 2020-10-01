let user = window.App.user;

// let authorizations = {
//     updateReply(reply) {
//         return reply.user_id === user.id;
//     }
// };
//
// module.exports = authorizations;

module.exports = {
    updateReply(reply) {
        return reply.user_id === user.id;
    }
};
