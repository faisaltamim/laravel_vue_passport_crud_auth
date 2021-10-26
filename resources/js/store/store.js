import Axios from "axios";


export default {
    state: {
        apiURL: "http://localhost:1000/api/",
        serverPath: "http://localhost:1000/",
        categoriesData: [], //eikhankar value gula getters e function e set korte hobe
        loading: 0,
        loadMore: "",
        //authentication part
        access_token: localStorage.getItem("auth_token") || null,
        varify_access_token: null
    },
    getters: {
        //finally jei data gula amra paisi eigula next e use korbo getters er theke niye
        categories(state) {
            return state.categoriesData;
        },
        // ifLoggedIn(state) {
        //     // if (state.access_token === null) {
        //     //     return false;
        //     // } else {
        //     //     return true;
        //     // }
        //     return 1;
        // },

        categoriesLoadMore(state) {
            return state.loadMore;
        }
    },
    actions: {
        // payloadNextData means category.vue er moddhe mounted e function run korar somoy load more er jei nextPage data ache ta params hisabe pass korsi
        appsCategories(myGetData, CurrentPagePayload) {
            Axios.get(this.state.apiURL + "category?page=" + CurrentPagePayload)
                .then(function(response) {
                    //commit er moddhe 2 ta parameter hoy first er tay any name dewa jay commit hisabe ar second tay data
                    // console.log(response.data.categories);

                    myGetData.commit("getcategories", response.data); //eikahne 2 ta array pathate hobe tai bhenge kora jabe na eikhane tai loadMore er response and show data er jonno mutations e 2 vabe state e data dekhano hoise
                })
                .catch(function(error) {
                    iziToast.error({
                        title: "Error",
                        message:
                            "category didn't show for some technical issue!",
                        backgroundColor: "rgb(103 0 0)",
                        icon: "fas fa-times-circle"
                        // eta bootstrap er icon class
                    });
                })
                .finally(() => {
                    this.state.loading = 1;
                });
        },
        // spaLogin(context, payloadCredentials) {
        //     return new Promise((resolve, reject) => {
        //         Axios.post(this.state.apiURL + "auth/login", payloadCredentials)
        //             .then(response => {
        //                 // console.log(JSON.stringify(response.data));
        //                 let response_token = response.data.access_token;
        //                 context.commit("setToken", response_token);


        //                 console.log(response.data.access_token);

        //                 Axios.get(this.state.apiURL + "get-token", {
        //                     headers: {
        //                         Authorization: `Bearer ${response_token}`
        //                     }
        //                 })
        //                     .then(res => {
        //                         console.log(res.data.user_data_verify);
        //                         // resolve(res);
        //                     })
        //                     .catch(error => {
        //                         // reject(error);
        //                     });

        //                 localStorage.setItem(
        //                     "auth_token",
        //                     response.data.access_token
        //                     // JSON.stringify(response.data.access_token)
        //                 );
        //                 resolve(response);
        //             })
        //             .catch(error => {
        //                 reject(error);
        //                 iziToast.error({
        //                     title: "Error",
        //                     message:
        //                         "you can't login for some technical issues!",
        //                     backgroundColor: "rgb(103 0 0)",
        //                     icon: "fas fa-times-circle"
        //                     // eta bootstrap er icon class
        //                 });
        //             })
        //             .finally(() => {
        //                 //
        //             });
        //     });
        // },
        logout(removeContext) {
            return new Promise((resolve, reject) => {
                Axios.defaults.headers.common["Authorization"] =
                    "Bearer " + removeContext.state.access_token;
                Axios.post(this.state.apiURL + "auth/logout")
                    .then(response => {
                        removeContext.commit("removeToken");
                        resolve(response);
                        localStorage.removeItem("auth_token");
                    })
                    .catch(error => {
                        iziToast.error({
                            title: "Error",
                            message:
                                "you can't logout for some technical issues!",
                            backgroundColor: "rgb(103 0 0)",
                            icon: "fas fa-times-circle"
                            // eta bootstrap er icon class
                        });
                        reject(error);
                    })
                    .finally(() => {
                        //
                    });
            });
        },
    },
    mutations: {
        //action er value ta abar mutations er maddhome state e pass korte hobe

        //action er vitore commit er moddhe jei function name ta lekhsi oita diye function likhte hobe then 1st parameters er moddhe state property ta mus call korte hobe then commit er 2nd parameters er data dhorar jonno jekono name use kore ekta param dite hobe sekhetre action property er function params er sathe mil thaka valo cause oikhan theke data gula ashbe
        getcategories(state, myGetData) {
            state.categoriesData = myGetData.categories.data; //state er vitorer array tar name equal amader get data deya hoise
            state.loadMore = myGetData.categories; //state er vitorer array tar name equal amader get data deya hoise
        },
        setToken(state, accessToken) {
            state.access_token = accessToken; //this access token use for logout instant
        },
        removeToken(state) {
            state.access_token = null;
        }
    },
    modules: {
        //er vitore abar state ,getters,actions, mutations thakbe
    }
};
