import Axios from "axios";

export default {
    state: {
        apiURL: "http://localhost:8000/api/",
        serverPath: "http://localhost:8000/",
        categoriesData: [], //eikhankar value gula getters e function e set korte hobe
        loading:0,
    },
    getters: {
        //finally jei data gula amra paisi eigula next e use korbo getters er theke niye
        categories(state) {
            return state.categoriesData;
        },
       
    },
    actions: {
        appsCategories(myGetData) {
            Axios.get(this.state.apiURL + "category")
                .then(function(response) {
                    //commit er moddhe 2 ta parameter hoy first er tay any name dewa jay commit hisabe ar second tay data
                    myGetData.commit(
                        "getcategories",
                        response.data.categories.data
                    );
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
        }
    },
    mutations: {
        //action er value ta abar mutations er maddhome state e pass korte hobe

        //action er vitore commit er moddhe jei function name ta lekhsi oita diye function likhte hobe then 1st parameters er moddhe state property ta mus call korte hobe then commit er 2nd parameters er data dhorar jonno jekono name use kore ekta param dite hobe sekhetre action property er function params er sathe mil thaka valo cause oikhan theke data gula ashbe
        getcategories(state, myGetData) {
            state.categoriesData = myGetData; //state er vitorer array tar name equal amader get data deya hoise
        },
    
    },
    modules: {
        //er vitore abar state ,getters,actions, mutations thakbe
    }
};
