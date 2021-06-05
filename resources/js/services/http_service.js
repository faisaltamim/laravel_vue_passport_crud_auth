import store from "../store/store";
// import Axios from "axios";
// if you use axios globally then no need to import axios here

export function http() {
    return axios.create({
        baseURL: store.state.apiURL
    });
}

export function httpFile() {
    return axios.create({
        baseURL: store.state.apiURL,
        headers: {
            "Content-Type": "multipart/form-data"
        }
    });
}
