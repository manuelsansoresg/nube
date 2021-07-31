export const helperFollow = {
    follow: function(ins) {

        ins.isSpiner = true;
        axios.post
        ('/user/follow', {user_follow_id: user_follow_id, _token: this.csrf})
            .then(function (response) {
                var result   = response.data;
                ins.isSpiner = false;

            })
            .catch(function (error) {

            })
    }
};