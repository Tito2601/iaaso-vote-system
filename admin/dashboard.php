<style>
.card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.1);
    border: 1px solid #e3eaf7;
    padding: 25px;
    margin: 70px auto 20px auto;
    max-width: 500px;
    width: 85%;
}

.admin-info {
    text-align: center;
    margin-bottom: 20px;
    padding: 15px;
    background: #f4f8fc;
    border-radius: 6px;
    border: 1px solid #e3eaf7;
}

.admin-name {
    font-size: 1.2em;
    font-weight: bold;
    color: #1a237e;
    margin: 0 0 6px 0;
}

.admin-role {
    color: #1565c0;
    margin: 0;
    font-size: 0.95em;
}

.stats-container {
    background: #fff;
    border: 1px solid #e3eaf7;
    border-radius: 6px;
    padding: 15px;
    margin-bottom: 15px;
}

.stat-item {
    text-align: center;
    padding: 12px;
    background: #f4f8fc;
    border-radius: 4px;
    margin-bottom: 15px;
    border: 1px solid #e3eaf7;
}

.stat-item:last-child {
    margin-bottom: 0;
}

.stat-value {
    font-size: 1.8em;
    font-weight: bold;
    color: #1a237e;
    margin: 0 0 5px 0;
}

.stat-label {
    color: #1565c0;
    margin: 0;
    font-size: 0.95em;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-top: 20px;
}

.action-button {
    display: inline-block;
    padding: 12px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    text-align: center;
    transition: all 0.2s;
    font-size: 0.95em;
}

.view-results {
    background: #1565c0;
    color: #fff;
}

.view-results:hover {
    background: #0d47a1;
    text-decoration: none;
    transform: translateY(-1px);
}

.manage-voters {
    background: #27ae60;
    color: #fff;
}

.manage-voters:hover {
    background: #219a52;
    text-decoration: none;
    transform: translateY(-1px);
}

.bottom-links {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #e3eaf7;
}

.logout-button {
    display: inline-block;
    background: #c0392b;
    color: #fff;
    padding: 8px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.2s;
    font-size: 0.95em;
}

.logout-button:hover {
    background: #a93226;
    text-decoration: none;
    transform: translateY(-1px);
}

@media screen and (max-width: 600px) {
    .card {
        padding: 15px;
        margin: 70px auto 15px auto;
        width: 90%;
    }

    .action-buttons {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .stat-value {
        font-size: 1.5em;
    }
}
</style> 