import { useMutation } from "@tanstack/vue-query";
import api from "../api";

const signIn = async (signInCredentials) => {
    const response = await api.post("/auth/login", signInCredentials);
    return response.data;
};

export const useSignInMutation = () => useMutation({ mutationFn: signIn });
