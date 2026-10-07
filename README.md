<div align=center>

<a href="https://github.com/Athexblackhat2/SPY-CAM"><img src="spy-cam.png" alt="0" border="0" /></a> 

![Geo-Phone](https://img.shields.io/badge/version-v[2.0]-blue.svg)

# 🕵️‍♂️ Spy Cam Tool
Disclaimer: This tool is for educational and authorized testing purposes only. Unauthorized use against individuals without explicit consent is illegal and unethical.

---

## 📋 Description
A penetration testing tool that demonstrates how webcam access can be obtained through social engineering techniques. The tool creates a fake web page that requests camera access and captures images when granted.

---

# 🚀 Features
Creates a convincing fake web page requesting camera access

Uses Cloudflared for public URL tunneling (no port forwarding required)

Captures IP addresses of visitors

Saves captured webcam images with timestamps

Automatic dependency installation

Clean interface with ASCII art banner

# 🔧 Prerequisites
Linux-based system (Ubuntu/Debian recommended)

Bash shell

Internet connection


## 📦 Installation & Usage
Clone or download the script

bash
chmod +x spy-cam.sh
Run the tool

bash 
./spy-cam.sh

# Follow the on-screen instructions

The script will automatically install dependencies (PHP, curl, wget, Cloudflared)

It will start a local PHP server

It will create a Cloudflared tunnel for public access

You'll receive a public URL to send to your target.

# Monitoring

The tool will monitor for connections

When someone visits the link and grants camera access, their IP and webcam image will be captured

Images are saved in the captures/ directory with timestamps
               OR
USE CONTROL PANEL FOR BEST AND COOL PERFOMANCE.

## 🛡️ How It Works
- Social Engineering: Presents a fake web page that appears legitimate

- Browser Permissions: Requests webcam access through standard browser APIs

- Data Capture: If permission is granted, captures a snapshot

- Caprure 5+ Photos in sigle Second.

- Data Exfiltration: Sends the captured data to the attacker's server

## 🟢 DEVELOPER
*** ATHEX BLACK HAT ***
