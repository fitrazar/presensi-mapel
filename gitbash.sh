#!/bin/bash

set -e

git add . || { echo "❌ Gagal menambahkan file."; exit 1; }

echo -n "Ingin isi commit message dan branch secara manual? (Y/N): "
read inputManual
timestamp=$(date "+%Y-%m-%d %H:%M:%S")

if [[ "$inputManual" == "Y" || "$inputManual" == "y" ]]; then
  echo 'Masukkan commit message (default: feat: update):'
  read commitMessage
  commitMessage=${commitMessage:-"feat: update"}

  echo 'Masukkan nama branch (default: main):'
  read branch
  branch=${branch:-main}
else
  commitMessage="feat: update"
  branch="main"
fi

changed_files=""

if git diff --cached --quiet; then
  echo "⚠️  Tidak ada perubahan yang di-stage. Skip commit, langsung push..."
else
  git commit -m "$commitMessage" || { echo "❌ Gagal commit."; exit 1; }

  # Ambil hash commit terakhir
  last_commit=$(git rev-parse HEAD)

  # Ambil daftar file yang diubah + status (A/M/D)
  changed_files=$(git diff-tree --no-commit-id --name-status -r "$last_commit")
fi

git push origin "$branch" || { echo "❌ Gagal push ke branch $branch."; exit 1; }

echo "✅ Berhasil push ke $branch dengan pesan commit: $commitMessage"

# Tambahkan ke gitlog.txt
{
  echo "$timestamp - Pushed to $branch with commit: $commitMessage"
  if [[ -n "$changed_files" ]]; then
    echo "  🗂️  Files changed (A=Added, M=Modified, D=Deleted):"
    echo "$changed_files" | sed 's/^/    /'
  fi
  echo ""
} >> gitlog.txt
