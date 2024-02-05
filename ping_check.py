#!/usr/bin/env python3
import mysql.connector
from mysql.connector import Error
import requests

# Function to check if a server is up or down
def is_server_up(ip):
    try:
        response = requests.get(f"http://{ip}", timeout=1)
        return response.status_code == 200
    except requests.RequestException:
        return False

# Function to connect to MySQL database
def connect_to_mysql():
    try:
        connection = mysql.connector.connect(
            host='localhost',
            database='users_data_ne3',
            user='root',
            password=''
        )

        if connection.is_connected():
            print("Connected to MySQL database")
            return connection

    except Error as e:
        print(f"Error: {e}")

# Function to insert data into MySQL
def insert_data(connection, name_place_device, device_name, ip_address, status):
    try:
        cursor = connection.cursor()

        sql = "INSERT INTO ping_results (name_place_device, device_name, ip_address, status) VALUES (%s, %s, %s, %s)"
        values = (name_place_device, device_name, ip_address, status)

        cursor.execute(sql, values)
        connection.commit()

        print("Data inserted into MySQL successfully")

    except Error as e:
        print(f"Error: {e}")

# Function to retrieve data from place_ne3 and update ping_results
def update_ping_results(connection):
    try:
        cursor = connection.cursor()

        # Retrieve data from place_ne3
        sql = "SELECT name_place, dell_name, dell_ip, riujie_name, riujie_ip, watchguard_name, watchguard_ip, zerotrust_name, zerotrust_ip, fortigate_name, fortigate_ip FROM place_ne3"
        cursor.execute(sql)
        rows = cursor.fetchall()

        # Update ping_results based on server status
        for row in rows:
            for device_type in ['dell', 'riujie', 'watchguard', 'zerotrust', 'fortigate']:
                name_place_device = row[f'{device_type}_name']
                device_name = f"{device_type.capitalize()} Device"
                ip_address = row[f'{device_type}_ip']
                status = 'Up' if is_server_up(ip_address) else 'Down'

                # Insert or update ping_results
                cursor.execute("SELECT id FROM ping_results WHERE name_place_device = %s", (name_place_device,))
                result = cursor.fetchone()

                if result:
                    # Update existing record
                    cursor.execute("UPDATE ping_results SET device_name = %s, ip_address = %s, status = %s WHERE id = %s",
                                   (device_name, ip_address, status, result[0]))
                else:
                    # Insert new record
                    cursor.execute("INSERT INTO ping_results (name_place_device, device_name, ip_address, status) VALUES (%s, %s, %s, %s)",
                                   (name_place_device, device_name, ip_address, status))

                connection.commit()

        print("Data updated in ping_results successfully")

    except Error as e:
        print(f"Error: {e}")

    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()
            print("MySQL connection closed")

# Example usage
try:
    connection = connect_to_mysql()

    # Update ping_results based on place_ne3 data
    update_ping_results(connection)

except Error as e:
    print(f"Error: {e}")
