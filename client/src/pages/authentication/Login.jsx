import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import "./Login.css";
import useAuthStatusAPI from "@Hooks/authentication/useAuthStatusAPI";
import useLoginAPI from "@Hooks/authentication/useLoginAPI";
import LoadingScene from "@Utilities/LoadingScene";
import useAuthStore from '@Store/useAuthStore';

const Login = () => {
    const [form, setForm] = useState({ account: "", password: "" });
    const [errorMessage, setErrorMessage] = useState("");
    const navigate = useNavigate();

    const {
        data: authStatus,
        isLoading: loadingAuth,
        refetch: refetchAuthStatus
    } = useAuthStatusAPI();

    const {
        mutate: login,
        isLoading: loadingLogin
    } = useLoginAPI(
        async () => {
            await refetchAuthStatus();
        },
        (error) => {
            setErrorMessage(error.message);
        }
    );

    const { setAuthenticated } = useAuthStore();

    useEffect(() => {
        if (authStatus?.authenticated) {
            setAuthenticated(true);
            navigate(-1);
        } else {
            setAuthenticated(false);
        }
    }, [authStatus, navigate, setAuthenticated]);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setForm({ ...form, [name]: value });
    };

    const handleLogin = (e) => {
        e.preventDefault();
        setErrorMessage("");
        login(form);
    };

    if (loadingAuth || loadingLogin) {
        return <LoadingScene />;
    }

    return (
        <div className="login-container">
            <div className="login-card">
                <form className="login-form" onSubmit={handleLogin}>
                    <h1 className="login-logo">E-Learning</h1>
                    <p className="login-subtitle">Welcome to E-Learning System!</p>

                    <div className="login-input-group">
                        <label htmlFor="account" className="login-label">
                            Account
                        </label>
                        <input
                            type="text"
                            id="account"
                            name="account"
                            className="login-input"
                            value={form.account}
                            onChange={handleInputChange}
                            required
                        />
                    </div>
                    <div className="login-input-group">
                        <label htmlFor="password" className="login-label">
                            Password
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            className="login-input"
                            value={form.password}
                            onChange={handleInputChange}
                            required
                        />
                    </div>

                    {errorMessage && (
                        <p className="error-message-auth">{errorMessage}</p>
                    )}

                    <button
                        type="submit"
                        className="login-button"
                        disabled={loadingLogin}
                    >
                        {loadingLogin ? "Logging in..." : "Login"}
                    </button>
                </form>

                <p className="login-footer">
                    New to E-Learning?{" "}
                    <a
                        className="sign-up-button"
                        onClick={() => navigate("/auth/signup")}
                    >
                        Sign up
                    </a>
                </p>
            </div>
        </div>
    );
};

export default Login;
