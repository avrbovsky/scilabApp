import { useQuery } from "@tanstack/vue-query";
import api from "../api";

const userList = () => api.get(`users`);
export const useUserListQuery = () =>
    useQuery({ queryKey: ["userList"], queryFn: userList });
