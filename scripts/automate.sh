#!/bin/bash


APP_DIR="C:\Users\amr20\Desktop"  
REPO_URL="https://github.com/abdallh249/linux.git" # Remote repository URL
BRANCH="main" # Target branch
JENKINS_JOB_URL="https://finer-easily-dassie.ngrok-free.app/job/linux/build" # Jenkins job build URL
JENKINS_USER="abed" # Jenkins username
JENKINS_API_TOKEN="2rqWUDTx5oA7FCoEg344jNO16A4_4k5Ccdu4YgRPmZaUAP6yL" # Jenkins API token

push_to_repository() {
    echo "Pushing changes to the repository..."
    cd "$APP_DIR" || exit

    git add .
    git commit -m "Automated update on $(date)"
    git push "$REPO_URL" "$BRANCH"
}


trigger_jenkins_job() {
    echo "Triggering Jenkins job..."
    curl -X POST "$JENKINS_JOB_URL" \
        --user "$JENKINS_USER:$JENKINS_API_TOKEN" \
        -H "Content-Type: application/json"
}


main() {
    push_to_repository
    trigger_jenkins_job
}


main
