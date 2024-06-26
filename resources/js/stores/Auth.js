import { defineStore } from "pinia";
import { ref } from "vue";
import { useCurrentLoggedUserMutation } from "@/api/queries/authQueries";

export const useAuthStore = defineStore(
    "auth",
    () => {
        const currentLoggedUser = ref();
        const token = ref("");

        const { mutateAsync } = useCurrentLoggedUserMutation();
        const authJson = localStorage.getItem("auth");
        if (authJson) {
            const auth = JSON.parse(authJson);
            if (auth?.currentLoggedUser) {
                mutateAsync()
                    .then((data) => {
                        if (data) {
                            const userData = data.data;

                            delete userData.created_at;
                            delete userData.email_verified_at;
                            delete userData.updated_at;

                            currentLoggedUser.value = userData;
                        }
                    })
                    .catch((err) => console.error(err.message));
            }
        }

        const signIn = (signedInUser, newToken) => {
            currentLoggedUser.value = signedInUser;
            token.value = newToken;
        };

        const signOut = () => {
            currentLoggedUser.value = undefined;
            token.value = "";
        };

        return { currentLoggedUser, token, signIn, signOut };
    },
    {
        persist: true,
    }
);
