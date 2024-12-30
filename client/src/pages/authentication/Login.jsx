import React, { useState, useEffect } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import "./Login.css";
import serverAPI from "ServerAPI";

const Login = () => {
    const [authenticated, setAuthenticated] = useState(false);
    const [form, setForm] = useState({ account: "", password: "" });
    const [loading, setLoading] = useState(false);

    const location = useLocation();
    const navigate = useNavigate();

    const checkAuthStatus = async () => {
        setLoading(true);
        try {
            const response = await serverAPI.get("/auth/status");
            setAuthenticated(response.data.authenticated || false);
        } catch (error) {
            console.error("Failed to check authentication status:", error);
            setAuthenticated(false);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        checkAuthStatus();
    }, [location]);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setForm({ ...form, [name]: value });
    };

    const handleLogin = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            const response = await serverAPI.post("/auth/login", form);
            console.log("Login successful:", response.data);
            setAuthenticated(true);
        } catch (error) {
            console.error("Login failed:", error.response?.data || error.message);
            alert("Invalid account or password");
        } finally {
            setLoading(false);
        }
    };

    const handleLogout = async () => {
        setLoading(true);
        try {
            const response = await serverAPI.post("/auth/logout");
            console.log("Logout successful:", response.data);
            setAuthenticated(false);

            navigate("/auth/login");
        } catch (error) {
            console.error("Logout failed:", error.response?.data || error.message);
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="login-container">
            <div className="login-card">
                {loading ? (
                    <div className="loading-spinner"></div>
                ) : authenticated ? (
                    <div className="login-status">
                        <p className="login-message">You are logged in!</p>
                        <button
                            className="login-button login-logout-button"
                            onClick={handleLogout}
                            disabled={loading}
                        >
                            Logout
                        </button>
                    </div>
                ) : (
                    <form className="login-form" onSubmit={handleLogin}>
                        <h1 className="login-logo">EduLearn</h1>
                        <p className="login-subtitle">Access your educational resources</p>
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
                        <button
                            type="submit"
                            className="login-button"
                            disabled={loading}
                        >
                            Login
                        </button>
                    </form>
                )}
                <p className="login-footer">
                    New to EduLearn? <a className="sign-up-button" onClick={() => {navigate('/auth/signup')}}>Sign up</a>
                </p>
            </div>
        </div>
    );
};

export default Login;
