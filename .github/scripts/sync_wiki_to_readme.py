#!/usr/bin/env python3
import os
import re
import requests
import json

def fetch_miraheze_content(wiki_api_url, page_title):
    """Fetch content from a Miraheze wiki page using the API."""
    params = {
        'action': 'query',
        'prop': 'revisions',
        'titles': page_title,
        'rvprop': 'content',
        'rvslots': 'main',
        'format': 'json'
    }
    
    try:
        print(f"Fetching content from {wiki_api_url} for page {page_title}")
        response = requests.get(wiki_api_url, params=params)
        response.raise_for_status()
        data = response.json()
        
        # Extract page content from response
        pages = data['query']['pages']
        page_id = list(pages.keys())[0]
        
        if int(page_id) < 0:  # Negative page IDs indicate missing pages
            print(f"Error: Page '{page_title}' not found on the wiki.")
            return None
            
        content = pages[page_id]['revisions'][0]['slots']['main']['*']
        return content
    except Exception as e:
        print(f"Failed to fetch wiki content: {e}")
        return None

def update_readme_with_wiki_content(wiki_content):
    """Update the README.md file with content from the wiki between specified markers."""
    try:
        # Check if README.md exists
        if not os.path.exists('README.md'):
            print("README.md does not exist. Creating new file.")
            with open('README.md', 'w', encoding='utf-8') as f:
                f.write(f"<!-- START MIRAHEZE CONTENT -->\n{wiki_content}\n<!-- END MIRAHEZE CONTENT -->")
            return True
        
        # Read existing README.md
        with open('README.md', 'r', encoding='utf-8') as f:
            readme_content = f.read()
        
        # Look for the content markers
        start_marker = "<!-- START MIRAHEZE CONTENT -->"
        end_marker = "<!-- END MIRAHEZE CONTENT -->"
        
        if start_marker in readme_content and end_marker in readme_content:
            # Replace content between markers
            pattern = re.compile(f"{start_marker}(.*?){end_marker}", re.DOTALL)
            updated_content = pattern.sub(f"{start_marker}\n{wiki_content}\n{end_marker}", readme_content)
            
            # Write updated content back to README.md
            with open('README.md', 'w', encoding='utf-8') as f:
                f.write(updated_content)
            
            print("README.md updated successfully.")
            return True
        else:
            print("Markers not found in README.md. Adding them with wiki content.")
            with open('README.md', 'w', encoding='utf-8') as f:
                f.write(f"{start_marker}\n{wiki_content}\n{end_marker}")
            return True
    except Exception as e:
        print(f"Failed to update README.md: {e}")
        return False

def main():
    # Get wiki API URL and page title from environment variables
    wiki_url = os.environ.get('MIRAHEZE_WIKI_URL', 'https://panalawahigdocs.miraheze.org')
    page_title = os.environ.get('MIRAHEZE_PAGE_TITLE', 'Main_Page')
    
    # Use the direct API URL if provided, otherwise construct it
    api_url = wiki_url
    if not api_url.endswith('api.php'):
        if not api_url.endswith('/'):
            api_url += '/'
        api_url += 'w/api.php'
    
    # Fetch wiki content
    wiki_content = fetch_miraheze_content(api_url, page_title)
    if not wiki_content:
        return False
    
    # Update README.md with wiki content
    return update_readme_with_wiki_content(wiki_content)

if __name__ == "__main__":
    success = main()
    exit(0 if success else 1)
