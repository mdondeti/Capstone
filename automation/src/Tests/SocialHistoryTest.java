package Tests;

import static org.testng.Assert.assertEquals;

import java.io.FileInputStream;

import org.apache.poi.ss.usermodel.DataFormatter;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFRow;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.junit.BeforeClass;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;

import Repos.LoginPage;
import Repos.SocialHistory;
import Repos.hpiPage;
import Repos.threePanelPage;
import Repos.vitalSignsSectionPage;

public class SocialHistoryTest {
	WebDriver driver = new FirefoxDriver();
	@DataProvider(name="social")
	public static Object[][] dataInputFromExcel() throws Exception
	{
		XSSFWorkbook workBook; 
		XSSFSheet sheet;
		XSSFRow row;
		int i=0;
		int j=0;
		Object[][] DataCellValues;

		//HashMap<String, String> hmap = new HashMap<String, String>();
		Boolean value = true;
		System.out.println("got here excel");
		FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
		workBook = new XSSFWorkbook(fs);
		sheet = workBook.getSheet("SocialHistory");

		int k=sheet.getLastRowNum();//get the number of rows

		int l=sheet.getRow(0).getLastCellNum();//get the number of columns in first row

		//define a string type two dimensional array
		DataCellValues = new Object[k+1][l];
		for(i=0;i<=k;i++)
		{
			row= sheet.getRow(i);
			for(j=0;j<l-1;j++)
			{
				XSSFCell cell= row.getCell(j);	
				if(row.getCell(j)==null)
				{
					DataCellValues[i][j]="";
				}
				else
				{
					DataCellValues[i][j]= new DataFormatter().formatCellValue(row.getCell(j));
				}


			}
		}
		return DataCellValues;
	}
	//	@org.testng.annotations.BeforeClass
	//	public void beforeClass()
	//	{
	//		 
	//		System.out.println("got here");  
	//			
	//		
	//	}

	@Test(dataProvider="social")
	public void testHPI(String User,String SmokeTobacco,String NonSmokeTobacco,
			String Alcohol,String sexualActivity,String Comment, String value) throws Exception
	{
		LoginPage.GoToPage(driver);
		LoginPage.LoginAsStudent(driver);

		driver.findElement(By.partialLinkText(User)).click();
		threePanelPage.MedicalHistory(driver).click();
		//
		Thread.sleep(5000);
		//smoke tobacco
		if(SmokeTobacco.contains("Yes"))
		{
			SocialHistory.SmokeTobaccoYes(driver).click();
		}
		else if(SmokeTobacco.contains("No"))
		{
			SocialHistory.SmokeTobaccoNo(driver).click();
		}

		//non smoke tobacco
		if(NonSmokeTobacco.contains("Yes"))
		{
			SocialHistory.NonSmokeTobaccoYes(driver).click();
		}
		else if(NonSmokeTobacco.contains("No"))
		{
			SocialHistory.NonSmokeTobaccoNo(driver).click();
		}

		//sexual activity 
		if(sexualActivity.contains("Yes"))
		{
			SocialHistory.SexuallyActive(driver).click();
		}
		else if(sexualActivity.contains("No"))
		{
			SocialHistory.SexuallyNonActive(driver).click();
		}


		//alcohol
		if(Alcohol.contains("Yes"))
		{
			SocialHistory.YesAlcohol(driver).click();
		}
		else if(Alcohol.contains("Yes"))
		{
			SocialHistory.NoAlcohol(driver).click();
		}

		//input comment
		if(Comment.length()>0)
		{
			SocialHistory.SocialHistoryComment(driver).sendKeys(Comment);
		}

		//click save

		SocialHistory.SaveSocialHistory(driver).click();
		//validate
		assertEquals(SocialHistory.SocialHistoryComment(driver).getText().contains(Comment),true );

		if(SmokeTobacco.contains("Yes"))
		{
			assertEquals(SocialHistory.SmokeTobaccoYes(driver).isSelected(), true);
		}
		else if(SmokeTobacco.contains("No"))
		{
			assertEquals(SocialHistory.SmokeTobaccoNo(driver).isSelected(), true);

		}

		//non smoke tobacco
		if(NonSmokeTobacco.contains("Yes"))
		{
			assertEquals(SocialHistory.NonSmokeTobaccoYes(driver).isSelected(), true);

		}
		else if(NonSmokeTobacco.contains("No"))
		{
			assertEquals(SocialHistory.NonSmokeTobaccoNo(driver).isSelected(), true);
		}

		//sexual activity 
		if(sexualActivity.contains("Yes"))
		{
			assertEquals(SocialHistory.SexuallyActive(driver).isSelected(), true);

		}
		else if(sexualActivity.contains("No"))
		{
			assertEquals(SocialHistory.SexuallyNonActive(driver).isSelected(), true);

		}


		//alcohol
		if(Alcohol.contains("Yes"))
		{
			assertEquals(SocialHistory.YesAlcohol(driver).isSelected(), true);

		}
		else if(Alcohol.contains("Yes"))
		{
			assertEquals(SocialHistory.NoAlcohol(driver).isSelected(), true);

		}

		//input comment
		if(Comment.length()>0)
		{
			assertEquals(SocialHistory.SocialHistoryComment(driver).getText().contains(Comment), true);

		}

		//check clear

		SocialHistory.clearSocialComment(driver).click();
		
		//should i get the dirty crap


		//back to dashboard and check if data exists
		vitalSignsSectionPage.backToDash(driver).click();
		driver.findElement(By.partialLinkText(User)).click();
		
		//validate
		assertEquals(SocialHistory.SocialHistoryComment(driver).getText().contains(Comment),true );

		if(SmokeTobacco.contains("Yes"))
		{
			assertEquals(SocialHistory.SmokeTobaccoYes(driver).isSelected(), true);
		}
		else if(SmokeTobacco.contains("No"))
		{
			assertEquals(SocialHistory.SmokeTobaccoNo(driver).isSelected(), true);

		}

		//non smoke tobacco
		if(NonSmokeTobacco.contains("Yes"))
		{
			assertEquals(SocialHistory.NonSmokeTobaccoYes(driver).isSelected(), true);

		}
		else if(NonSmokeTobacco.contains("No"))
		{
			assertEquals(SocialHistory.NonSmokeTobaccoNo(driver).isSelected(), true);
		}

		//sexual activity 
		if(sexualActivity.contains("Yes"))
		{
			assertEquals(SocialHistory.SexuallyActive(driver).isSelected(), true);

		}
		else if(sexualActivity.contains("No"))
		{
			assertEquals(SocialHistory.SexuallyNonActive(driver).isSelected(), true);

		}


		//alcohol
		if(Alcohol.contains("Yes"))
		{
			assertEquals(SocialHistory.YesAlcohol(driver).isSelected(), true);

		}
		else if(Alcohol.contains("Yes"))
		{
			assertEquals(SocialHistory.NoAlcohol(driver).isSelected(), true);

		}

		//input comment
		if(Comment.length()>0)
		{
			assertEquals(SocialHistory.SocialHistoryComment(driver).getText().length()>0, false);

		}
		
		SocialHistory.SocialHistoryComment(driver).sendKeys(Comment);
		
		
		
		threePanelPage.MedicalHistory(driver).click();
		driver.switchTo().alert().dismiss();
		//check if landed on same page
		assertEquals(SocialHistory.SocialHistoryComment(driver).getText(), Comment);
		SocialHistory.SaveSocialHistory(driver).click();
		
		
		threePanelPage.MedicalHistory(driver).click();
		driver.switchTo().alert().accept();

		threePanelPage.MedicalHistory(driver).click();	
		//check if navigated
		

		
		//driver.close();


		
	}

	

}
