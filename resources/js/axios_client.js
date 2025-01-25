import axios from "axios";
import Cookies from "js-cookie";

const axios_client = axios.create({
  baseURL: import.meta.env.VITE_API_URL, // Use your API base URL
  withCredentials: true,
  headers: {
    "Content-Type": "application/json",
  },
});

axios_client.interceptors.request.use(
  (config) => {
    const authToken = Cookies.get("auth"); // Retrieve auth token from cookies
    const csrfToken = Cookies.get("XSRF-TOKEN"); // Retrieve CSRF token from cookies

    console.log("Auth Token:", authToken);
    console.log("CSRF Token:", csrfToken);

    if (csrfToken) {
      config.headers["X-XSRF-TOKEN"] = csrfToken;
    }

    if (authToken) {
      config.headers.Authorization = `Bearer ${authToken}`;
    }

    return config;
  },
  (error) => {
    console.error("Error in request:", error);
    return Promise.reject(error);
  }
);

export default axios_client;
