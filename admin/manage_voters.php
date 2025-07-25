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

.voters-container {
    background: #fff;
    border: 1px solid #e3eaf7;
    border-radius: 6px;
    padding: 15px;
    margin-bottom: 15px;
}

.voter-list {
    margin-bottom: 20px;
}

.voter-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    background: #f4f8fc;
    border-radius: 4px;
    margin-bottom: 10px;
    border: 1px solid #e3eaf7;
}

.voter-item:last-child {
    margin-bottom: 0;
}

.voter-details {
    flex-grow: 1;
}

.voter-name {
    font-size: 1em;
    font-weight: bold;
    color: #1a237e;
    margin: 0 0 4px 0;
}

.voter-id {
    color: #1565c0;
    margin: 0;
    font-size: 0.9em;
}

.voter-actions {
    display: flex;
    gap: 8px;
}

.action-button {
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
    font-size: 0.9em;
    transition: all 0.2s;
}

.edit-button {
    background: #1565c0;
    color: #fff;
}

.edit-button:hover {
    background: #0d47a1;
    text-decoration: none;
    transform: translateY(-1px);
}

.delete-button {
    background: #c0392b;
    color: #fff;
}

.delete-button:hover {
    background: #a93226;
    text-decoration: none;
    transform: translateY(-1px);
}

.add-voter-form {
    background: #f4f8fc;
    border-radius: 6px;
    padding: 15px;
    border: 1px solid #e3eaf7;
}

.form-group {
    margin-bottom: 15px;
}

.form-group:last-child {
    margin-bottom: 0;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #1a237e;
    font-weight: bold;
    font-size: 0.95em;
}

.form-group input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e3eaf7;
    border-radius: 4px;
    font-size: 0.95em;
}

.form-group input:focus {
    outline: none;
    border-color: #1565c0;
    box-shadow: 0 0 0 2px rgba(21, 101, 192, 0.1);
}

.submit-button {
    background: #27ae60;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    font-size: 0.95em;
    transition: all 0.2s;
}

.submit-button:hover {
    background: #219a52;
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

.back-button {
    display: inline-block;
    background: #1565c0;
    color: #fff;
    padding: 8px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.2s;
    font-size: 0.95em;
}

.back-button:hover {
    background: #0d47a1;
    text-decoration: none;
    transform: translateY(-1px);
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

    .voter-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .voter-actions {
        width: 100%;
        justify-content: flex-end;
    }

    .action-button {
        padding: 8px 15px;
    }
}
</style> 